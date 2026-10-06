<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    private const CACHE_KEY = 'site-settings';

    /**
     * Every editable setting with its label, input type and default value.
     *
     * @return array<string, array{label: string, type: string, default: string, group: string, placeholder?: string, help?: string}>
     */
    public static function definitions(): array
    {
        return [
            'whatsapp' => ['group' => 'contact', 'label' => 'WhatsApp Number', 'type' => 'tel', 'default' => (string) config('penida.booking.whatsapp', '6281236300562'), 'placeholder' => '6281236300562', 'help' => 'International format without + or spaces. Used by every “Chat on WhatsApp” / “Book with WhatsApp” button.'],
            'whatsapp_message' => ['group' => 'contact', 'label' => 'Default WhatsApp Message', 'type' => 'text', 'default' => 'Hi Penida Gili, I would like to ask about a booking.', 'placeholder' => 'Hi Penida Gili, …'],
            'email' => ['group' => 'contact', 'label' => 'Booking Email', 'type' => 'email', 'default' => (string) config('penida.booking.email', 'adityarana916@gmail.com'), 'placeholder' => 'hello@penidagili.com'],
            'phone' => ['group' => 'contact', 'label' => 'Phone (display)', 'type' => 'text', 'default' => '+62 812 3630 0562', 'placeholder' => '+62 812 …'],
            'address' => ['group' => 'contact', 'label' => 'Office Address', 'type' => 'text', 'default' => 'Jl. Hang Tuah, Sanur, Denpasar, Bali', 'placeholder' => 'Sanur, Bali'],
            'instagram' => ['group' => 'social', 'label' => 'Instagram URL', 'type' => 'url', 'default' => 'https://instagram.com/penidagili', 'placeholder' => 'https://instagram.com/…'],
            'facebook' => ['group' => 'social', 'label' => 'Facebook URL', 'type' => 'url', 'default' => 'https://facebook.com/penidagili', 'placeholder' => 'https://facebook.com/…'],
            'tiktok' => ['group' => 'social', 'label' => 'TikTok URL', 'type' => 'url', 'default' => '', 'placeholder' => 'https://tiktok.com/@…'],
            'youtube' => ['group' => 'social', 'label' => 'YouTube URL', 'type' => 'url', 'default' => '', 'placeholder' => 'https://youtube.com/@…'],
            'show_whatsapp_social' => ['group' => 'social', 'label' => 'Show WhatsApp icon in footer', 'type' => 'toggle', 'default' => '1'],
            'show_email_social' => ['group' => 'social', 'label' => 'Show Email icon in footer', 'type' => 'toggle', 'default' => '1'],
            'show_floating_whatsapp' => ['group' => 'social', 'label' => 'Floating WhatsApp button', 'type' => 'toggle', 'default' => '1'],
        ];
    }

    /** @return array<string, string> All settings with defaults applied. */
    public static function all_values(): array
    {
        $stored = [];

        try {
            if (Schema::hasTable('settings')) {
                $stored = Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('value', 'key')->all());
            }
        } catch (Throwable) {
            $stored = [];
        }

        return collect(static::definitions())
            ->map(fn (array $def, string $key) => array_key_exists($key, $stored) && $stored[$key] !== null ? (string) $stored[$key] : $def['default'])
            ->all();
    }

    public static function value(string $key, ?string $fallback = null): ?string
    {
        return static::all_values()[$key] ?? $fallback;
    }

    /** @param array<string, string|null> $values */
    public static function store(array $values): void
    {
        foreach ($values as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget(self::CACHE_KEY);
    }

    /** wa.me link with the default (or a custom) message. */
    public static function whatsappUrl(?string $message = null): string
    {
        $number = preg_replace('/\D+/', '', (string) static::value('whatsapp'));
        $text = $message ?? static::value('whatsapp_message');

        return 'https://wa.me/'.$number.($text ? '?text='.rawurlencode($text) : '');
    }
}
