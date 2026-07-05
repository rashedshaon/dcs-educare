<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\TeamMember;

class TeamMembers extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Team Members', 'description' => 'Displays active team members.'];
    }

    public function onRun()
    {
        $this->page['teamMembers'] = TeamMember::active()->sorted()->with('image')->get();
    }
}
