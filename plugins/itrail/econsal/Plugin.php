<?php namespace ItRail\Econsal;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = [
        'RainLab.Pages',
        'RainLab.Blog',
        'JanVince.SmallContactForm',
        'Raviraj.Rjgallery',
    ];

    public function pluginDetails()
    {
        return [
            'name' => 'Econsal',
            'description' => 'Dynamic education consultancy content for the Econsal theme.',
            'author' => 'ItRail',
            'icon' => 'icon-graduation-cap',
        ];
    }

    public function registerComponents()
    {
        return [
            \ItRail\Econsal\Components\SiteSettings::class => 'siteSettings',
            \ItRail\Econsal\Components\HomeSlider::class => 'homeSlider',
            \ItRail\Econsal\Components\InfoBlock::class => 'infoBlock',
            \ItRail\Econsal\Components\RequiredDocuments::class => 'requiredDocuments',
            \ItRail\Econsal\Components\CountriesList::class => 'countriesList',
            \ItRail\Econsal\Components\CountryDetails::class => 'countryDetails',
            \ItRail\Econsal\Components\VisaCategoryList::class => 'visaCategoryList',
            \ItRail\Econsal\Components\ServicesAccordion::class => 'servicesAccordion',
            \ItRail\Econsal\Components\SuccessStudents::class => 'successStudents',
            \ItRail\Econsal\Components\TeamMembers::class => 'teamMembers',
            \ItRail\Econsal\Components\ContentBlock::class => 'contentBlock',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Econsal Settings',
                'description' => 'Manage site branding, colors, contact details, and social links.',
                'category' => 'Econsal',
                'icon' => 'icon-cog',
                'class' => \ItRail\Econsal\Models\Settings::class,
                'order' => 500,
                'permissions' => ['itrail.econsal.manage_settings'],
            ],
        ];
    }
}
