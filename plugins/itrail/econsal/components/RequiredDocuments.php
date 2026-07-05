<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\ContentBlock;

class RequiredDocuments extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Required Documents', 'description' => 'Loads the required documents homepage block.'];
    }

    public function onRun()
    {
        $this->page['requiredDocuments'] = ContentBlock::where('code', 'required-documents')->active()->with('image')->first();
    }
}
