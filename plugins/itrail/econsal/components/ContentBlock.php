<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\ContentBlock as ContentBlockModel;

class ContentBlock extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Content Block', 'description' => 'Loads a reusable Econsal content block by code.'];
    }

    public function defineProperties()
    {
        return [
            'code' => [
                'title' => 'Code',
                'description' => 'Content block code/slug.',
                'default' => '',
                'type' => 'string',
            ],
            'var' => [
                'title' => 'Page variable',
                'description' => 'Twig variable name to expose.',
                'default' => 'contentBlock',
                'type' => 'string',
            ],
            'applySeo' => [
                'title' => 'Use block SEO fields',
                'description' => 'Applies this block SEO data to the current page.',
                'default' => false,
                'type' => 'checkbox',
            ],
        ];
    }

    public function onRun()
    {
        $code = $this->property('code');
        $var = $this->property('var') ?: 'contentBlock';
        $block = ContentBlockModel::where('code', $code)->active()->with(['image', 'og_image'])->first();
        $this->page[$var] = $block;

        if ($block && $this->property('applySeo')) {
            $this->page['meta_title'] = $block->meta_title ?: $block->title;
            $this->page['meta_description'] = $block->meta_description ?: $block->subtitle;
            $this->page['meta_keywords'] = $block->meta_keywords;
            $this->page['seo_og_image'] = $block->og_image ? $block->og_image->getPath() : null;
        }
    }
}
