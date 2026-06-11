<?php namespace Bol\DcsWpImport\Models;

use Model;

class Enquiry extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'bol_dcswpimport_enquiries';

    protected $fillable = [
        'name', 'email', 'phone', 'service', 'message', 'ip_address', 'user_agent', 'status'
    ];

    public $rules = [
        'name' => 'required|max:120',
        'phone' => 'required|max:40',
        'email' => 'nullable|email|max:190',
    ];
}
