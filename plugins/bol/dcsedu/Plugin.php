<?php namespace Bol\Dcsedu;
use System\Classes\PluginBase;
class Plugin extends PluginBase
{
    public function pluginDetails(){return ['name'=>'DCS EDUCARE Dynamic','description'=>'Dynamic blog/contact','author'=>'BOL','icon'=>'icon-graduation-cap'];}
    public function registerComponents(){return [\Bol\Dcsedu\Components\BlogList::class=>'blogList',\Bol\Dcsedu\Components\BlogPost::class=>'blogPost',\Bol\Dcsedu\Components\ContactForm::class=>'contactForm'];}
}
