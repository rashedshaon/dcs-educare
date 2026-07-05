<?php namespace ItRail\Econsal\Controllers;

use Backend\Classes\SettingsController;
use BackendMenu;
use ItRail\Econsal\Models\Settings as SettingsModel;

class Settings extends SettingsController
{
    public $implement = [\Backend\Behaviors\FormController::class];

    public $formConfig = 'config_form.yaml';

    public $settingsItemCode = 'settings';

    public $requiredPermissions = ['itrail.econsal.manage_settings'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ItRail.Econsal', 'econsal', 'settings');
    }

    public function index()
    {
        $this->pageTitle = 'Econsal Settings';
        $this->update();
    }

    public function index_onSave()
    {
        return $this->update_onSave();
    }

    public function formFindModelObject($recordId)
    {
        return SettingsModel::instance();
    }
}
