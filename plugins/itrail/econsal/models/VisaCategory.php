<?php namespace ItRail\Econsal\Models;

use System\Models\File;

class VisaCategory extends BaseContentModel
{
    public $table = 'itrail_econsal_visa_categories';

    public $rules = [
        'title' => 'required',
    ];

    public $attachOne = [
        'image' => File::class,
        'icon_image' => File::class,
        'og_image' => File::class,
    ];
}
