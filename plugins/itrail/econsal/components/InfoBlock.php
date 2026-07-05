<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\ContentBlock;

class InfoBlock extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Info Block', 'description' => 'Loads the homepage info block.'];
    }

    public function onRun()
    {
        $this->page['infoBlock'] = ContentBlock::where('code', 'info-block')->active()->with('image')->first();
    }
}
