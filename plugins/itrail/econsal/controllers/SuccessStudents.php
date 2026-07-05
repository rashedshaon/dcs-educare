<?php namespace ItRail\Econsal\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use ItRail\Econsal\Models\SuccessStudent;

class SuccessStudents extends Controller
{
    public $implement = [\Backend\Behaviors\ListController::class, \Backend\Behaviors\FormController::class, \Backend\Behaviors\ReorderController::class];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $requiredPermissions = ['itrail.econsal.manage_content'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ItRail.Econsal', 'econsal', 'success_students');
    }

    public function onDelete()
    {
        foreach ((array) post('checked') as $id) {
            if ($record = SuccessStudent::find($id)) {
                $record->delete();
            }
        }

        Flash::success('Selected success students deleted successfully.');
        return $this->listRefresh();
    }
}
