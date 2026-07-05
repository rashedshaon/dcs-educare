<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\VisaCategory;

class VisaCategoryList extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Visa Category List', 'description' => 'Displays active visa categories.'];
    }

    public function onRun()
    {
        $this->page['visaCategories'] = VisaCategory::active()->sorted()->with(['image', 'icon_image'])->get();
    }
}
