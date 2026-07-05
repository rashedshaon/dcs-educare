<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\SuccessStudent;

class SuccessStudents extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Success Students', 'description' => 'Displays active success student stories.'];
    }

    public function onRun()
    {
        $this->page['successStudents'] = SuccessStudent::active()->sorted()->with('image')->get();
    }
}
