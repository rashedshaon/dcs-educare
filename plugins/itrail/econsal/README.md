# ItRail.Econsal

Dynamic content plugin for the `econsal` OctoberCMS theme.

## Requirements

- OctoberCMS v4
- RainLab.Pages
- RainLab.Blog
- JanVince.SmallContactForm
- Raviraj.Rjgallery

## Install

1. Place the plugin at `plugins/itrail/econsal`.
2. Place the theme at `themes/econsal`.
3. Run `php artisan october:migrate`.
4. Activate the `econsal` theme in the backend.
5. Create RainLab.Pages static menus with codes `main-menu` and `footer-menu`.
6. Configure Econsal settings from Backend > Econsal > Settings.

## CMS Pages

The theme includes:

- Home: `/`
- About Us: `/about`
- Student Services: `/student-services`
- Study Abroad: `/study-abroad`
- Blog: `/blog`
- Blog detail: `/blog/post/:slug`
- Gallery: `/gallery`
- Contact Us: `/contact`
- Sitemap: `/sitemap.xml`
- Robots: `/robots.txt`

Seed data creates starter slides, countries, visa categories, services, success students, team members, and reusable content blocks. Replace demo text and upload production images from the backend before launch.
