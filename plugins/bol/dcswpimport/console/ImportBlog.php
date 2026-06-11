<?php namespace Bol\DcsWpImport\Console;

use Illuminate\Console\Command;
use RainLab\Blog\Models\Post;
use RainLab\Blog\Models\Category;
use Carbon\Carbon;

class ImportBlog extends Command
{
    protected $name = 'dcswpimport:blog';
    protected $description = 'Import DCS WordPress blog posts into RainLab.Blog with idempotent production-safe mapping.';

    public function handle()
    {
        if (!class_exists(Post::class)) {
            $this->error('RainLab.Blog is not installed. Install it before running this import.');
            return 1;
        }

        $path = plugins_path('bol/dcswpimport/data/blog-posts.json');
        if (!is_file($path)) {
            $this->error('Missing data file: '.$path);
            return 1;
        }

        $items = json_decode(file_get_contents($path), true);
        if (!is_array($items)) {
            $this->error('Invalid JSON: '.$path);
            return 1;
        }

        $imported = 0;
        $skipped = 0;

        foreach ($items as $item) {
            $slug = trim($item['slug'] ?? '');
            $title = trim($item['title'] ?? '');

            if (!$slug || !$title) {
                $skipped++;
                $this->warn('Skipped item without slug/title. WP ID: '.($item['wp_id'] ?? 'unknown'));
                continue;
            }

            $post = Post::firstOrNew(['slug' => $slug]);
            $post->title = $title;
            $post->slug = $slug;
            $post->excerpt = trim($item['excerpt'] ?? '') ?: null;
            $post->content = $this->cleanContent($item['content'] ?? '');
            $post->content_html = $post->content;
            $post->published = true;
            $post->published_at = $this->parseDate($item['published_at'] ?? null);
            $post->user_id = $post->user_id ?: 1;
            $post->save();

            $categoryIds = [];
            foreach (($item['categories'] ?? []) as $cat) {
                $catSlug = trim($cat['slug'] ?? '');
                $catName = trim($cat['name'] ?? '');
                if (!$catSlug || !$catName) {
                    continue;
                }

                $category = Category::firstOrCreate(
                    ['slug' => $catSlug],
                    ['name' => $catName, 'description' => '']
                );
                $categoryIds[] = $category->id;
            }

            if ($categoryIds) {
                $post->categories()->sync($categoryIds);
            }

            $imported++;
            $this->line('Imported/updated: '.$post->title);
        }

        $this->info("DCS blog import completed. Imported/updated: {$imported}. Skipped: {$skipped}.");
        return 0;
    }

    protected function parseDate($value)
    {
        try {
            return $value ? Carbon::parse($value) : now();
        } catch (\Throwable $e) {
            return now();
        }
    }

    protected function cleanContent($html)
    {
        $html = (string) $html;
        $html = preg_replace('/<!--\s*\/?wp:[^>]*-->/i', '', $html);
        $html = str_replace('http://dcsedu.org/wp-content/uploads/', 'https://dcsedu.org/wp-content/uploads/', $html);
        return trim($html);
    }
}
