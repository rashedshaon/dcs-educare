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

## Google Tag Manager

Open **Econsal Settings > Analytics**, enable Google Tag Manager, and enter the container ID (for example, `GTM-ABC1234`). The theme loads both standard GTM snippets and pushes privacy-safe engagement and lead events to `dataLayer`; it never includes submitted form values, phone numbers, or email addresses.

Available custom events include `contact_click`, `cta_click`, `social_click`, `outbound_click`, `map_click`, `navigation_click`, `file_download`, `select_content`, `service_expand`, `form_start`, `form_submit`, `form_error`, `generate_lead`, `video_start`, and `view_content`. Configure the corresponding Custom Event triggers and GA4 Event tags inside the GTM container, then publish it. YouTube embeds also include `enablejsapi=1`, so GTM's built-in YouTube Video trigger can observe them.

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
