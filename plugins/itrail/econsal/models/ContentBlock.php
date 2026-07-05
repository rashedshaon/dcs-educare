<?php namespace ItRail\Econsal\Models;

use Str;

class ContentBlock extends BaseContentModel
{
    public $table = 'itrail_econsal_content_blocks';

    public $rules = [
        'code' => 'required',
    ];

    public function beforeValidate()
    {
        if ($this->code) {
            $this->code = Str::slug($this->code);
        }
    }

    public function getImagePathAttribute(): ?string
    {
        return $this->image ? $this->image->getPath() : null;
    }
}
