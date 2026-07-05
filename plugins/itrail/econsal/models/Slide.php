<?php namespace ItRail\Econsal\Models;

class Slide extends BaseContentModel
{
    public $table = 'itrail_econsal_slides';

    public $rules = [
        'title' => 'required',
    ];
}
