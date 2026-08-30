<?php namespace ItRail\Econsal\Components;

use Cms\Classes\ComponentBase;
use Cms;
use ItRail\Econsal\Models\Settings;

class SiteSettings extends ComponentBase
{
    public function componentDetails()
    {
        return ['name' => 'Site Settings', 'description' => 'Loads Econsal global settings.'];
    }

    public function onRun()
    {
        $this->page['settings'] = Settings::instance();
        $this->page['phones'] = Settings::listPhones();
        $this->page['emails'] = Settings::listEmails();
        $this->page['addresses'] = Settings::listAddresses();
        $this->page['socialLinks'] = array_merge(Settings::socialLinks(), Settings::customSocialLinks());
        $this->page['whatsappLink'] = Settings::whatsAppLink();
        $this->page['gtmContainerId'] = Settings::gtmContainerId();
        $this->page['canonicalUrl'] = Cms::fullUrl(request()->path() === '/' ? null : request()->path());
    }
}
