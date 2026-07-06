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

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([A-Za-z0-9_-]{6,})/', $this->youtube_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
        }

        $query = parse_url($this->youtube_url, PHP_URL_QUERY);
        parse_str((string) $query, $params);

        return !empty($params['v'])
            ? 'https://www.youtube.com/embed/' . $params['v'] . '?rel=0'
            : null;
    }
}
