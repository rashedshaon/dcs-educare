<?php namespace ItRail\Econsal\Components;

use App;
use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\Country;

class CountryDetails extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Country Details', 'description' => 'Displays one active country by slug.'];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'description' => 'Country slug.',
                'default' => '{{ :slug }}',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $country = Country::active()
            ->where('slug', $this->property('slug'))
            ->with(['image', 'flag_image', 'og_image'])
            ->first();

        if (!$country) {
            App::abort(404);
        }

        $this->page['country'] = $country;
        $this->page->title = $country->meta_title ?: $country->name;
        $this->page['meta_title'] = $country->meta_title ?: $country->name;
        $this->page['meta_description'] = $country->meta_description ?: $country->short_description;
        $this->page['meta_keywords'] = $country->meta_keywords;
        $this->page['seo_og_image'] = $country->og_image
            ? $country->og_image->getPath()
            : ($country->image ? $country->image->getPath() : null);
    }
}
