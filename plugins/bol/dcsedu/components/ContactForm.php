<?php namespace Bol\Dcsedu\Components;
use Cms\Classes\ComponentBase; use Bol\Dcsedu\Models\ContactLead; use Flash; use Request;
class ContactForm extends ComponentBase{public function componentDetails(){return ['name'=>'DCS Contact Form','description'=>'Stores leads'];} public function onSubmit(){ContactLead::create(['name'=>post('name'),'email'=>post('email'),'phone'=>post('phone'),'subject'=>post('subject'),'message'=>post('message'),'ip_address'=>Request::ip()]); Flash::success('Thank you. Your message has been sent.');}}
