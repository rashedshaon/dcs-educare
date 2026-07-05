<?php namespace ItRail\Econsal\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use ItRail\Econsal\Models\VisaCategory;

class VisaCategories extends Controller
{
    public $implement = [\Backend\Behaviors\ListController::class, \Backend\Behaviors\FormController::class, \Backend\Behaviors\ReorderController::class];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $requiredPermissions = ['itrail.econsal.manage_content'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ItRail.Econsal', 'econsal', 'visa_categories');
    }

    public function onDelete()
    {
        foreach ((array) post('checked') as $id) {
            if ($record = VisaCategory::find($id)) {
                $record->delete();
            }
        }

        Flash::success('Selected visa categories deleted successfully.');
        return $this->listRefresh();
    }
}
