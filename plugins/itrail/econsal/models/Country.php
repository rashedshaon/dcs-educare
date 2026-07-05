<?php namespace ItRail\Econsal\Models;

use System\Models\File;

class Country extends BaseContentModel
{
    public $table = 'itrail_econsal_countries';

    public $rules = [
        'name' => 'required',
    ];

    public $attachOne = [
        'image' => File::class,
        'flag_image' => File::class,
        'og_image' => File::class,
    ];
}
