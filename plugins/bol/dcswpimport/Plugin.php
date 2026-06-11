<?php namespace Bol\DcsWpImport;

use Backend;
use System\Classes\PluginBase;
use Bol\DcsWpImport\Components\LeadForm;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    public function pluginDetails()
    {
        return [
            'name' => 'DCS WordPress Import & Lead Tools',
            'description' => 'Production import helpers and native lead form for the DCS Education OctoberCMS conversion.',
            'author' => 'BOL',
            'icon' => 'icon-graduation-cap'
        ];
    }

    public function registerComponents()
    {
        return [
            LeadForm::class => 'dcsLeadForm',
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('dcswpimport.blog', \Bol\DcsWpImport\Console\ImportBlog::class);
    }
}
