<?php namespace ItRail\Econsal\Models;

class SuccessStudent extends BaseContentModel
{
    public $table = 'itrail_econsal_success_students';

    public $rules = [
        'student_name' => 'required',
    ];
}
