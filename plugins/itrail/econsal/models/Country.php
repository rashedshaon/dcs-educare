<?php namespace ItRail\Econsal\Models;

use Str;
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

    public function beforeValidate()
    {
        if (!$this->slug && $this->name) {
            $this->slug = $this->name;
        }

        if ($this->slug) {
            $this->slug = Str::slug($this->slug);
        }
    }
}
