<?php namespace ItRail\Econsal\Components;

use Cms;
use Cms\Classes\ComponentBase;
use ItRail\Econsal\Models\Country;
use RainLab\Blog\Models\Post;

class DynamicSitemap extends ComponentBase
{
    private const STATIC_PAGES = [
        ['page' => 'home', 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['page' => 'about', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['page' => 'student-services', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['page' => 'study-abroad', 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['page' => 'blog', 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['page' => 'gallery', 'changefreq' => 'monthly', 'priority' => '0.5'],
        ['page' => 'contact', 'changefreq' => 'monthly', 'priority' => '0.6'],
    ];

    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Sitemap',
            'description' => 'Builds sitemap entries from CMS pages, countries, and published blog posts.',
        ];
    }

    public function onRun()
    {
        $entries = [];
        $this->page['sitemapUrl'] = $this->absolutePageUrl('sitemap');
        $this->page['backendPath'] = '/' . trim((string) config('backend.uri', 'admin'), '/') . '/';

        if ($this->controller->getPage()->getBaseFileName() === 'robots') {
            return;
        }

        foreach (self::STATIC_PAGES as $item) {
            $entries[] = [
                'loc' => $this->absolutePageUrl($item['page']),
                'changefreq' => $item['changefreq'],
                'priority' => $item['priority'],
            ];
        }

        Country::active()
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(function ($country) use (&$entries) {
                $entries[] = [
                    'loc' => $this->absolutePageUrl('country-details', ['slug' => $country->slug]),
                    'lastmod' => optional($country->updated_at)->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                ];
            });

        Post::isPublished()
            ->orderBy('published_at', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(function ($post) use (&$entries) {
                $entries[] = [
                    'loc' => $this->absolutePageUrl('blog-post', ['slug' => $post->slug]),
                    'lastmod' => optional($post->updated_at)->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            });

        $this->page['sitemapEntries'] = array_values(array_filter(
            $entries,
            fn ($entry) => !empty($entry['loc'])
        ));
    }

    private function absolutePageUrl(string $page, array $parameters = []): ?string
    {
        $path = Cms::pageUrl($page, $parameters);

        if (!$path) {
            return null;
        }

        return filter_var($path, FILTER_VALIDATE_URL) ? $path : Cms::fullUrl($path);
    }
}
