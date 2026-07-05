<?php namespace ItRail\Econsal\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use ItRail\Econsal\Models\ContentBlock;

class ContentBlocks extends Controller
{
    public $implement = [\Backend\Behaviors\ListController::class, \Backend\Behaviors\FormController::class];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $requiredPermissions = ['itrail.econsal.manage_content'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ItRail.Econsal', 'econsal', 'content_blocks');
    }

    public function onDelete()
    {
        foreach ((array) post('checked') as $id) {
            if ($record = ContentBlock::find($id)) {
                $record->delete();
            }
        }

        Flash::success('Selected content blocks deleted successfully.');
        return $this->listRefresh();
    }
}
