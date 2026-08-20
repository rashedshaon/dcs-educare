<?php namespace ItRail\Econsal;

use Cms\Classes\Page;
use Event;
use Response;
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
            \ItRail\Econsal\Components\DynamicSitemap::class => 'dynamicSitemap',
        ];
    }

    public function boot()
    {
        Event::listen('cms.page.display', function ($controller, $url, $page, $result) {
            if (!$page instanceof Page || !is_string($result)) {
                return;
            }

            $contentTypes = [
                'robots' => 'text/plain; charset=UTF-8',
                'sitemap' => 'application/xml; charset=UTF-8',
            ];

            $pageName = $page->getBaseFileName();
            if (isset($contentTypes[$pageName])) {
                return Response::make($result, 200, [
                    'Content-Type' => $contentTypes[$pageName],
                ]);
            }
        });
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
