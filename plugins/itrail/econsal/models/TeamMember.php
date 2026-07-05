<?php namespace ItRail\Econsal\Models;

class TeamMember extends BaseContentModel
{
    public $table = 'itrail_econsal_team_members';

    public $rules = [
        'name' => 'required',
    ];
}
