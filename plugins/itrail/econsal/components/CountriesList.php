<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\Country;

class CountriesList extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Countries List', 'description' => 'Displays active countries.'];
    }

    public function onRun()
    {
        $this->page['countries'] = Country::active()->sorted()->with(['image', 'flag_image'])->get();
    }
}
