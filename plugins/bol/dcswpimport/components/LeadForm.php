<?php namespace Bol\DcsWpImport\Components;

use Cms\Classes\ComponentBase;
use Input;
use Mail;
use Validator;
use ValidationException;
use ApplicationException;
use Bol\DcsWpImport\Models\Enquiry;

class LeadForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'DCS Lead Form',
            'description' => 'Native OctoberCMS AJAX enquiry form for the converted DCS site.'
        ];
    }

    public function defineProperties()
    {
        return [
            'mailTo' => [
                'title' => 'Notification Email',
                'default' => 'info@dcsedu.org',
                'type' => 'string',
            ],
        ];
    }

    public function onSubmit()
    {
        $data = [
            'name' => trim((string) Input::get('name')),
            'email' => trim((string) Input::get('email')),
            'phone' => trim((string) Input::get('phone')),
            'service' => trim((string) Input::get('service')),
            'message' => trim((string) Input::get('message')),
        ];

        $validator = Validator::make($data, [
            'name' => 'required|min:2|max:120',
            'email' => 'nullable|email|max:190',
            'phone' => 'required|min:6|max:40',
            'service' => 'nullable|max:190',
            'message' => 'nullable|max:3000',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $enquiry = Enquiry::create($data + [
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
            'status' => 'new',
        ]);

        $to = trim((string) $this->property('mailTo')) ?: 'info@dcsedu.org';
        try {
            Mail::send('bol.dcswpimport::mail.enquiry', ['item' => $enquiry], function ($message) use ($to, $data) {
                $message->to($to);
                $message->subject('New DCS Education enquiry from '.$data['name']);
            });
        } catch (\Throwable $e) {
            // Do not block lead capture if mail transport is not configured yet.
            trace_log($e);
        }

        return [
            '#dcs-lead-message' => '<div class="alert alert-success">Thank you. Our counsellor will contact you soon.</div>',
            'ok' => true,
        ];
    }
}
