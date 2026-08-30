<?php namespace ItRail\Econsal\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use System\Behaviors\SettingsModel;
use System\Models\File;

class Settings extends Model
{
    use Validation;

    public $implement = [SettingsModel::class];

    public $settingsCode = 'itrail_econsal_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'enable_gtm' => ['boolean'],
        'gtm_container_id' => ['nullable', 'required_if:enable_gtm,1', 'regex:/^GTM-[A-Z0-9]+$/i'],
    ];

    public $attachOne = [
        'logo' => File::class,
        'favicon' => File::class,
        'og_image' => File::class,
    ];

    public function initSettingsData()
    {
        $this->site_name = 'Econsal';
        $this->header_button_text = 'Book Appointment';
        $this->header_button_link = '/contact';
        $this->footer_short_description = 'Professional study abroad counselling, admission, and visa support.';
        $this->copyright_text = 'Copyright © ' . date('Y') . ' Econsal. All rights reserved.';
        $this->primary_color = '#0f766e';
        $this->secondary_color = '#1d4ed8';
        $this->accent_color = '#f59e0b';
        $this->text_color = '#1f2937';
        $this->button_color = '#0f766e';
        $this->font_import_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&family=Merriweather:wght@400;700;900&family=Nunito+Sans:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&family=Source+Sans+3:wght@400;500;600;700;800;900&display=swap';
        $this->body_font_family = '"Plus Jakarta Sans", system-ui, sans-serif';
        $this->heading_font_family = '"Manrope", system-ui, sans-serif';
        $this->base_font_size = '16px';
        $this->heading_font_weight = '800';
        $this->enable_preloader = false;
        $this->enable_sticky_header = true;
        $this->enable_whatsapp_button = true;
        $this->enable_back_to_top = true;
        $this->enable_gtm = false;
        $this->google_site_verification = 'QXV-zPiy5LPvspGYcGYyrDjpPNczc7-Ea4pQumPRQZk';
    }

    public static function gtmContainerId(): ?string
    {
        if (!self::get('enable_gtm')) {
            return null;
        }

        $containerId = strtoupper(trim((string) self::get('gtm_container_id')));

        return preg_match('/^GTM-[A-Z0-9]+$/', $containerId) ? $containerId : null;
    }

    public static function listPhones(): array
    {
        return self::splitLines(self::get('phone_numbers'));
    }

    public static function listEmails(): array
    {
        return self::splitLines(self::get('emails'));
    }

    public static function listAddresses(): array
    {
        return self::splitLines(self::get('office_addresses'));
    }

    public static function socialLinks(): array
    {
        $items = [
            'facebook' => ['label' => 'Facebook', 'url' => self::get('facebook_url'), 'icon' => 'bi bi-facebook'],
            'instagram' => ['label' => 'Instagram', 'url' => self::get('instagram_url'), 'icon' => 'bi bi-instagram'],
            'linkedin' => ['label' => 'LinkedIn', 'url' => self::get('linkedin_url'), 'icon' => 'bi bi-linkedin'],
            'youtube' => ['label' => 'YouTube', 'url' => self::get('youtube_url'), 'icon' => 'bi bi-youtube'],
            'tiktok' => ['label' => 'TikTok', 'url' => self::get('tiktok_url'), 'icon' => 'bi bi-tiktok'],
            'whatsapp' => ['label' => 'WhatsApp', 'url' => self::whatsAppLink(), 'icon' => 'bi bi-whatsapp'],
            'twitter' => ['label' => 'X/Twitter', 'url' => self::get('twitter_url'), 'icon' => 'bi bi-twitter-x'],
        ];

        return array_values(array_filter($items, fn ($item) => !empty($item['url'])));
    }

    public static function customSocialLinks(): array
    {
        $rows = self::get('custom_social_links') ?: [];
        return array_values(array_filter($rows, fn ($row) => !empty($row['label']) && !empty($row['url'])));
    }

    public static function whatsAppLink(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) self::get('whatsapp_number'));
        return $number ? 'https://wa.me/' . $number : null;
    }

    protected static function splitLines($value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $value))));
    }
}
