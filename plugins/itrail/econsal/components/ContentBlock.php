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
        ];
    }

    public function onRun()
    {
        $code = $this->property('code');
        $var = $this->property('var') ?: 'contentBlock';
        $this->page[$var] = ContentBlockModel::where('code', $code)->active()->with('image')->first();
    }
}
