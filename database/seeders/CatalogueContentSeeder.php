<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Hotel;
use App\Support\RichText;
use Illuminate\Database\Seeder;

/**
 * Catalogue content v2 — long-form hotel, activity and article pages with photos that
 * match each title (source: database/seeders/data/catalogue-v2.json, built from data/src).
 *
 * Only rows that already exist are touched (matched by slug), so listings the admin
 * deleted are not brought back. Every field written here stays editable in the console.
 */
class CatalogueContentSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode((string) file_get_contents(database_path('seeders/data/catalogue-v2.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($data['hotels'] as $slug => $content) {
            $hotel = Hotel::query()->where('slug', $slug)->first();

            if (! $hotel) {
                continue;
            }

            $hotel->update([
                'image' => $content['image'],
                'harbor_distance' => $content['harbor_distance'],
                'description' => RichText::clean($content['description']),
                'gallery' => $content['gallery'],
                'highlights' => $content['highlights'],
                'policies' => $content['policies'],
                'nearby' => $content['nearby'],
            ]);

            foreach ($content['rooms'] as $name => $room) {
                $hotel->rooms()->where('name', $name)->update(['image' => $room['image']]);
            }
        }

        foreach ($data['activities'] as $slug => $content) {
            $description = RichText::clean($content['description']);

            Activity::query()->where('slug', $slug)->first()?->update([
                'image' => $content['image'],
                'summary_image' => $content['summary_image'],
                'gallery' => $content['gallery'],
                'intro' => $content['intro'],
                // The console edits one rich description; the summary mirrors it.
                'description' => $description,
                'summary' => $description,
                'experiences' => $content['experiences'],
                'included' => $content['included'],
                'excluded' => $content['excluded'],
                'important_notes' => $content['important_notes'],
            ]);
        }

        foreach ($data['articles'] as $slug => $content) {
            Article::query()->where('slug', $slug)->first()?->update([
                'body' => RichText::clean($content['body'], RichText::ALLOWED_ARTICLE),
                'read_time_minutes' => $content['read_time_minutes'],
                'hero_alt' => $content['hero_alt'],
            ]);
        }
    }
}
