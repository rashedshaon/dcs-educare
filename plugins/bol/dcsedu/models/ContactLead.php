<?php namespace Bol\Dcsedu\Models;
use Model;
class ContactLead extends Model{public $table='bol_dcsedu_contact_leads';protected $fillable=['name','email','phone','subject','message','ip_address'];}
