<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\Slide;

class HomeSlider extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Home Slider', 'description' => 'Displays active homepage slides.'];
    }

    public function onRun()
    {
        $this->page['slides'] = Slide::active()->sorted()->with('image')->get();
    }
}
