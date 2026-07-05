<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\Service;

class ServicesAccordion extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Services Accordion', 'description' => 'Displays active services in an accordion.'];
    }

    public function onRun()
    {
        $this->page['services'] = Service::active()->sorted()->with(['image', 'icon_image'])->get();
    }
}
