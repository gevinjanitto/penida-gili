<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Database\Seeder;

/**
 * Long-form copy for the travel articles that only shipped with a one-line body,
 * plus author bios. Only fills articles whose body is still a stub, so edits
 * made in the console are never overwritten.
 */
class ArticleContentSeeder extends Seeder
{
    public function run(): void
    {
        $bios = [
            'Capt. Wayan Sudira' => ['credential' => '15 years crossing the Badung Strait', 'bio' => 'Wayan has captained fast boats between Sanur, Penida and Lembongan since 2010 and now leads marine operations and safety briefings.'],
            'Dewa Krisna' => ['credential' => 'PADI Divemaster', 'bio' => 'Born in Ped village, Dewa guides snorkeling and diving trips around Nusa Penida, Lembongan and the Gili Islands.'],
        ];
        foreach ($bios as $name => $data) {
            Author::query()->where('name', $name)->whereNull('bio')->update($data);
        }
        Author::query()->whereNull('bio')->get()->each(fn (Author $a) => $a->update([
            'bio' => $a->name.' writes about island travel, local culture and smart ways to explore Bali and its neighbouring islands.',
            'credential' => $a->credential ?: 'Penida Gili travel writer',
        ]));

        foreach ($this->articles() as $slug => $data) {
            $article = Article::query()->where('slug', $slug)->first();
            if (! $article || mb_strlen(strip_tags((string) $article->body)) > 400) {
                continue;
            }
            $article->update($data);
        }
    }

    /** @return array<string, array<string, mixed>> */
    private function articles(): array
    {
        return [
            'top-7-unmissable-snorkeling-spots-around-nusa-penida-gili-meno' => [
                'subtitle' => 'From manta cleaning stations to turtle meadows — the reefs worth the boat ride.',
                'lead' => 'The waters around Nusa Penida and the Gili Islands are part of the Coral Triangle, home to more than 1,300 species of reef fish.',
                'lead_follow' => 'Here are the seven spots our guides return to again and again, with the best time to go and how to get there by fast boat.',
                'hero_caption' => 'Manta Point, Nusa Penida',
                'read_time_minutes' => 7,
                'tags' => ['#Snorkeling', '#NusaPenida', '#GiliIslands'],
                'body' => '<h2>1. Manta Point, Nusa Penida</h2><p>Reef mantas with wingspans of up to four metres visit this cleaning station almost every day. Conditions can be choppy, so book a morning trip and bring a long-sleeve rash guard.</p><h2>2. Crystal Bay</h2><p>A calm, sheltered bay on the west coast with excellent visibility, colourful hard corals and the chance of spotting the Mola Mola between July and October.</p><h2>3. Gamat Bay</h2><p>Gentle slopes, schooling fish and a fringing reef in pristine condition — perfect for beginners and families.</p><h2>4. Mangrove Point, Nusa Lembongan</h2><ul><li>Best for drift snorkeling on an incoming tide.</li><li>Look out for turtles, batfish and giant clams.</li><li>Only 30 minutes by fast boat from Sanur.</li></ul><h2>5. Turtle Point, Gili Trawangan</h2><p>Green and hawksbill turtles graze on the seagrass just off the north-east coast. Swim out from the beach or join a glass-bottom boat tour.</p><h2>6. Nest Statues, Gili Meno</h2><p>Forty-eight life-size statues by Jason deCaires Taylor sit in four metres of water and are slowly becoming a living reef.</p><h2>7. Toyapakeh Wall</h2><p>Strong currents bring nutrients that feed huge sea fans and soft corals. Recommended for confident swimmers with a guide.</p><blockquote>Always book licensed operators, wear reef-safe sunscreen and never touch the coral or the wildlife.</blockquote>',
            ],
            'best-time-of-day-for-calm-waters-crossing-the-badung-strait-comfortably' => [
                'subtitle' => 'A captain\'s guide to tides, swell and picking the smoothest sailing.',
                'lead' => 'The Badung Strait between Bali and Nusa Penida can go from glassy to lively in a few hours. Timing is everything.',
                'lead_follow' => 'Follow these tips from our marine operations team to enjoy a comfortable 30 to 45 minute crossing.',
                'hero_caption' => 'Early morning departure from Sanur',
                'read_time_minutes' => 5,
                'tags' => ['#BadungStrait', '#FastBoat', '#TravelTips'],
                'body' => '<h2>Why mornings are calmer</h2><p>Trade winds usually pick up after 11:00, building short wind-swell across the strait. Departures between <strong>07:00 and 09:30</strong> are typically the smoothest of the day.</p><h2>Dry season vs. wet season</h2><ul><li><strong>April – October:</strong> stronger south-east trade winds, but very predictable mornings.</li><li><strong>November – March:</strong> lighter winds, occasional storms; check the forecast the evening before.</li></ul><h2>Choose the right boat</h2><p>Catamarans such as the Sanjaya Ocean Queen or Angel Billabong I are wider and more stable than mono-hull speedboats, which makes a noticeable difference on choppy afternoons.</p><h2>Where to sit</h2><p>Sit in the middle or towards the back of the cabin, where the motion is gentlest. Look at the horizon and avoid reading on your phone.</p><blockquote>Prone to sea sickness? Take medication 30 minutes before boarding and have a light breakfast.</blockquote><h2>What if the sea is rough?</h2><p>Our partners will reschedule free of charge when the harbour master suspends sailings. Keep your WhatsApp active — we message every passenger directly.</p>',
            ],
            'kelingking-t-rex-cliff-diamond-beach-how-to-plan-your-day-trip' => [
                'subtitle' => 'One day, two icons: how to see Kelingking and Diamond Beach without the crowds.',
                'lead' => 'Kelingking\'s T-Rex shaped headland and the carved staircase of Diamond Beach are the two most photographed spots on Nusa Penida.',
                'lead_follow' => 'They sit on opposite coasts, so a little planning goes a long way.',
                'hero_caption' => 'Kelingking Beach viewpoint',
                'read_time_minutes' => 6,
                'tags' => ['#Kelingking', '#DiamondBeach', '#NusaPenida'],
                'body' => '<h2>Sample itinerary</h2><ul><li><strong>07:00</strong> Fast boat Sanur → Nusa Penida.</li><li><strong>08:15</strong> Driver pick-up at the harbour, head west to Kelingking.</li><li><strong>09:00</strong> Viewpoint photos before the tour buses arrive.</li><li><strong>12:00</strong> Lunch with a view in Ped.</li><li><strong>13:30</strong> Diamond Beach &amp; Atuh Beach on the east coast.</li><li><strong>16:00</strong> Return boat to Bali.</li></ul><h2>Hiking down to Kelingking Beach</h2><p>The trail is steep and takes 30–45 minutes each way. Wear proper shoes, carry water and skip it in the rain.</p><h2>Diamond Beach tips</h2><p>The stairs are carved into the cliff and are safe, but the swimming can be rough. Stay in the shallow lagoon on the left side.</p><blockquote>Roads on Penida are narrow and bumpy — hiring a local driver is safer and faster than renting a scooter.</blockquote><h2>Book it together</h2><p>Combine a return fast boat ticket with our West Penida day tour in one booking and save on transfers.</p>',
            ],
            'choosing-between-fast-ferry-vs-speedboat-comfort-speed-price-comparison' => [
                'subtitle' => 'Catamaran, mono-hull or speedboat — which crossing suits your trip?',
                'lead' => 'All fast boats to the islands look similar online, but hull design, size and engines make a real difference on the water.',
                'lead_follow' => 'Here is how the main options compare on comfort, speed and price.',
                'hero_caption' => 'Catamaran fast ferry at Sanur',
                'read_time_minutes' => 6,
                'tags' => ['#FastBoat', '#Comparison', '#TravelTips'],
                'body' => '<h2>Catamaran fast ferries</h2><p>Twin hulls make catamarans the most stable option. Expect air-conditioned cabins, toilets and capacity for 100–150 passengers. Ideal for families and anyone prone to sea sickness.</p><h2>Mono-hull fast boats</h2><p>Lighter and often a little faster, mono-hulls are great value on short crossings like Sanur to Nusa Lembongan, but feel the swell more on windy afternoons.</p><h2>Private speedboats</h2><p>Charter a speedboat when you travel as a group or need a custom time. Prices start around IDR 3.500.000 per boat one way.</p><h2>Quick comparison</h2><ul><li><strong>Comfort:</strong> Catamaran &gt; Mono-hull &gt; Speedboat</li><li><strong>Speed:</strong> Speedboat &gt; Mono-hull &gt; Catamaran</li><li><strong>Price per person:</strong> Mono-hull from IDR 100.000, Catamaran from IDR 90.000, Private from IDR 3.5M per boat</li></ul><blockquote>Whatever you choose, check that life jackets and passenger insurance are included — every operator on Penida Gili includes both.</blockquote>',
            ],
            'what-to-pack-for-an-island-getaway-to-nusa-lembongan-and-ceningan' => [
                'subtitle' => 'Travel light, stay dry and be ready for beach landings.',
                'lead' => 'Many boats to Nusa Lembongan land directly on the beach, so you will be wading ashore with your bags.',
                'lead_follow' => 'Pack smart with this checklist from our crew.',
                'hero_caption' => 'Beach landing at Jungutbatu',
                'read_time_minutes' => 4,
                'tags' => ['#NusaLembongan', '#PackingList', '#Ceningan'],
                'body' => '<h2>Essentials</h2><ul><li>Dry bag for phones, passports and cash.</li><li>Reef-safe sunscreen and a hat.</li><li>Sandals you can get wet — no flip-flops on the cliffs.</li><li>Cash in rupiah: ATMs on the island can run dry.</li></ul><h2>Luggage tips</h2><p>Each passenger can bring up to 20kg. Soft bags are easier for the crew to carry through the surf than hard suitcases.</p><h2>For Ceningan and the Yellow Bridge</h2><p>Rent a scooter or bicycle to cross the famous Yellow Bridge. Bring a light rain jacket between November and March.</p><blockquote>Leave valuables at your hotel in Bali if you are only doing a day trip — travel light and enjoy the island.</blockquote>',
            ],
            'balinese-cultural-etiquette-visiting-pura-goa-giri-putri-and-sacred-temples' => [
                'subtitle' => 'How to dress, behave and show respect at Nusa Penida\'s sacred sites.',
                'lead' => 'Pura Goa Giri Putri is a Hindu temple hidden inside a limestone cave — you enter through a gap barely wide enough for one person.',
                'lead_follow' => 'Visiting is a highlight of any trip, as long as you follow a few simple customs.',
                'hero_caption' => 'Entrance to Pura Goa Giri Putri',
                'read_time_minutes' => 5,
                'tags' => ['#Culture', '#Temples', '#NusaPenida'],
                'body' => '<h2>Dress code</h2><p>Wear a sarong and sash (selendang) — they are usually available to borrow at the entrance for a small donation. Cover your shoulders.</p><h2>Temple etiquette</h2><ul><li>Never stand higher than the priest or the shrines.</li><li>Do not step on offerings (canang sari) on the ground.</li><li>Women who are menstruating are asked not to enter.</li><li>Ask before photographing people praying.</li></ul><h2>Ceremonies</h2><p>If a ceremony is taking place, wait quietly at the side. You may be invited to receive holy water and rice — accept with your right hand.</p><blockquote>A respectful smile and a quiet voice go a long way. "Suksma" means thank you in Balinese.</blockquote><h2>Getting there</h2><p>Goa Giri Putri is on the east coast, about 40 minutes from Toyapakeh harbour. Combine it with Diamond Beach on the same day.</p>',
            ],
        ];
    }
}
