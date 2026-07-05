<?php namespace ItRail\Econsal\Models;

use Model;
use System\Models\File;
use October\Rain\Database\Traits\Sortable;

abstract class BaseContentModel extends Model
{
    use Sortable;

    public $timestamps = true;

    public $rules = [];

    public $sortable = ['sort_order'];

    public $attachOne = [
        'image' => File::class,
        'og_image' => File::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getImagePathAttribute(): ?string
    {
        return $this->image ? $this->image->getPath() : null;
    }
}
