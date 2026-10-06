"""Source for catalogue-v2.json (hotels). Run build.py to regenerate the JSON."""

GOOD_TO_KNOW = lambda checkin, checkout, breakfast, transfer, kids, extra: [
    {"label": "Check-in", "value": checkin},
    {"label": "Check-out", "value": checkout},
    {"label": "Breakfast", "value": breakfast},
    {"label": "Harbor transfer", "value": transfer},
    {"label": "Children", "value": kids},
    {"label": "Good to know", "value": extra},
]

HOTELS = {
    "the-nusa-penida-resort-spa": {
        "image": "nusa-penida-resort.png",
        "harbor_distance": "10 minutes from Toya Pakeh harbor",
        "description": (
            "<p>Experience unparalleled luxury on the edge of the world. <strong>The Nusa Penida Resort &amp; Spa</strong> sits on the "
            "quiet north-west coast between Toya Pakeh and Ped, a sanctuary of tranquility with sweeping views across the Badung Strait "
            "to Bali&rsquo;s volcanoes. Designed for the discerning traveler, the resort blends modern elegance with authentic Balinese charm.</p>"
            "<p>Days start with sunrise over Mount Agung from your private balcony and end with candle-lit dinners on the cliff terrace. "
            "In between, swim in the cascading infinity pool, unwind with a traditional boreh massage in the spa pavilions, or let our "
            "concierge arrange snorkeling with manta rays and private drivers to Kelingking and Diamond Beach.</p>"
            "<ul><li>Infinity pool and sunset bar overlooking the Indian Ocean</li><li>Balinese spa with four treatment pavilions</li>"
            "<li>Free fast-boat pick-up from Toya Pakeh harbor</li></ul>"
        ),
        "gallery": [
            {"image": "pool-main.png", "alt": "Infinity pool overlooking the ocean"},
            {"image": "the-nusa-penida/cliff-lounge.jpg", "alt": "Cliff-edge lounge above the sea"},
            {"image": "room-deluxe.png", "alt": "Deluxe ocean room"},
            {"image": "sunset-dining.png", "alt": "Sunset dining terrace"},
            {"image": "suite.png", "alt": "Spa treatment pavilion"},
            {"image": "cocktail.png", "alt": "Cocktail at the sunset bar"},
            {"image": "room-villa.png", "alt": "Private pool villa"},
        ],
        "highlights": [
            {"title": "Infinity pool above the strait", "body": "A 30-metre infinity edge looks straight across to Mount Agung — at its best at sunrise and during the golden hour."},
            {"title": "Balinese spa rituals", "body": "Four open-air pavilions offer boreh scrubs, flower baths and traditional massage using island-grown coconut oil."},
            {"title": "Ocean-to-table dining", "body": "The cliff terrace serves the day’s catch from Toya Pakeh fishermen alongside Balinese classics and a long wine list."},
            {"title": "Seamless island transfers", "body": "We meet every fast boat at Toya Pakeh harbor and can book your onward Penida Gili crossing at reception."},
        ],
        "policies": GOOD_TO_KNOW("From 2:00 PM", "Until 12:00 PM", "Included for all room types, 7:00–10:30 AM",
                                 "Free pick-up from Toya Pakeh harbor", "Welcome; under 6 stay free using existing beds",
                                 "Reef-safe sunscreen is provided at the pool"),
        "nearby": [
            {"name": "Toya Pakeh Harbor", "distance": "10 min drive"},
            {"name": "Crystal Bay Beach", "distance": "25 min drive"},
            {"name": "Manta Point (by boat)", "distance": "35 min"},
            {"name": "Kelingking Beach", "distance": "45 min drive"},
            {"name": "Pura Dalem Ped Temple", "distance": "8 min drive"},
            {"name": "Goa Giri Putri Cave Temple", "distance": "40 min drive"},
        ],
        "rooms": {
            "Deluxe Ocean Room": {"image": "room-deluxe.png"},
            "Private Pool Villa": {"image": "room-villa.png"},
        },
    },
    "meru-resort-spa": {
        "image": "meru-resort.png",
        "harbor_distance": "20 minutes from Toya Pakeh harbor",
        "description": (
            "<p><strong>Meru Resort &amp; Spa</strong> is a hideaway of garden villas just above Crystal Bay, one of Nusa Penida&rsquo;s "
            "calmest and clearest bays. Thatched pavilions, frangipani gardens and private plunge pools make it a favourite for honeymooners "
            "and anyone who wants the beach at their doorstep.</p>"
            "<p>Walk five minutes downhill for morning snorkeling over coral gardens, return for a long breakfast by the pool and spend the "
            "afternoon with a massage in the open-air spa. At sunset the beach club lights its lanterns and the whole bay turns gold.</p>"
            "<ul><li>Garden pool villas with outdoor bathtubs</li><li>Beach club on Crystal Bay with sun loungers</li>"
            "<li>Daily snorkel trips to Crystal Bay and Gamat Bay</li></ul>"
        ),
        "gallery": [
            {"image": "meru/crystal-bay-beach.jpg", "alt": "Crystal Bay seen from the resort hill"},
            {"image": "villa-pool.jpg", "alt": "Private pool villa"},
            {"image": "meru/garden-pool-villa.jpg", "alt": "Garden villa with plunge pool"},
            {"image": "meru/villa-bedroom.jpg", "alt": "Teak villa bedroom"},
            {"image": "meru/beach-club.jpg", "alt": "Beach club loungers on the bay"},
            {"image": "suite-terrace.jpg", "alt": "Suite terrace with ocean view"},
            {"image": "meru/villa-terrace.jpg", "alt": "Villa terrace and pool"},
        ],
        "highlights": [
            {"title": "Steps from Crystal Bay", "body": "A short garden path leads to the white sand and the reef — the best snorkeling on the island is right here."},
            {"title": "Villas with plunge pools", "body": "Every villa hides behind its own stone wall, with a plunge pool, sun deck and an outdoor rain shower."},
            {"title": "Sunset beach club", "body": "Lanterns, fresh coconuts and grilled seafood as the sun drops behind Bali’s Bukit peninsula."},
            {"title": "Mola-mola season trips", "body": "From July to October our dive partner runs early boats to spot the giant sunfish at Crystal Bay."},
        ],
        "policies": GOOD_TO_KNOW("From 2:00 PM", "Until 11:00 AM", "Included, served in the pavilion or in-villa",
                                 "Shared shuttle from Toya Pakeh harbor (IDR 75,000)", "Children of all ages welcome",
                                 "Roads to Crystal Bay are steep — we recommend our shuttle over scooters"),
        "nearby": [
            {"name": "Crystal Bay Beach", "distance": "5 min walk"},
            {"name": "Angel's Billabong", "distance": "35 min drive"},
            {"name": "Broken Beach", "distance": "35 min drive"},
            {"name": "Toya Pakeh Harbor", "distance": "20 min drive"},
            {"name": "Sakti village market", "distance": "10 min drive"},
        ],
        "rooms": {
            "Deluxe Ocean Room": {"image": "meru/villa-bedroom.jpg"},
            "Private Pool Villa": {"image": "meru/garden-pool-villa.jpg"},
        },
    },
    "grand-hyatt-resort-spa": {
        "image": "detail/pool-loungers.jpg",
        "harbor_distance": "5 minutes from Sanur fast-boat harbor",
        "description": (
            "<p>Set on the Sanur beachfront along Jalan Danau Tamblingan, <strong>Grand Hyatt Resort &amp; Spa</strong> is the easiest "
            "base for island hopping: the Sanur fast-boat harbor is five minutes away, yet the resort feels a world apart with lagoon "
            "pools, palm-shaded gardens and a calm reef-protected beach.</p>"
            "<p>Spend the night before your early crossing in an ocean-view room, take the free shuttle to the harbor in the morning, and "
            "come back to Sanur&rsquo;s cafés, sunrise beach walks and the spa after your trip to Nusa Penida, Lembongan or the Gilis.</p>"
            "<ul><li>Lagoon pools and a quiet stretch of Sanur beach</li><li>Free shuttle to the Sanur fast-boat harbor</li>"
            "<li>Luggage storage while you explore the islands</li></ul>"
        ),
        "gallery": [
            {"image": "sanur/beachfront-aerial.jpg", "alt": "Sanur beachfront from above"},
            {"image": "pool-loungers.jpg", "alt": "Pool loungers in the garden"},
            {"image": "sanur/pool-courtyard.jpg", "alt": "Courtyard pool villa"},
            {"image": "sanur/ocean-balcony.jpg", "alt": "Ocean-view balcony"},
            {"image": "sanur/spa.png", "alt": "Spa treatment room"},
            {"image": "sanur/balcony-lounge.jpg", "alt": "Balcony lounge with sea view"},
            {"image": "sanur/sea-view-counter.jpg", "alt": "Sea-view breakfast counter"},
        ],
        "highlights": [
            {"title": "Five minutes to the boats", "body": "Our shuttle leaves for the Sanur harbor before every morning departure, so you never miss the calm-water crossing."},
            {"title": "Reef-protected beach", "body": "Sanur’s outer reef keeps the water flat — perfect for paddle boarding at sunrise and for families with young children."},
            {"title": "Luggage minding", "body": "Travel light to the islands: leave big bags with the concierge free of charge for up to seven nights."},
            {"title": "Sanur at your doorstep", "body": "The beachfront promenade, night market and dozens of cafés are an easy walk from the lobby."},
        ],
        "policies": GOOD_TO_KNOW("From 3:00 PM (early check-in on request)", "Until 12:00 PM", "Buffet breakfast from 6:00 AM for early boats",
                                 "Free shuttle to Sanur harbor", "Kids’ club for ages 4–12",
                                 "Luggage storage is free while you visit the islands"),
        "nearby": [
            {"name": "Sanur Fast-Boat Harbor", "distance": "5 min drive"},
            {"name": "Sanur Beach Promenade", "distance": "2 min walk"},
            {"name": "Sindhu Night Market", "distance": "10 min walk"},
            {"name": "Ngurah Rai Airport", "distance": "30 min drive"},
            {"name": "Ubud", "distance": "50 min drive"},
        ],
        "rooms": {
            "Deluxe Ocean Room": {"image": "sanur/ocean-balcony.jpg"},
            "Private Pool Villa": {"image": "sanur/pool-courtyard.jpg"},
        },
    },
    "semabu-hills-hotel-nusa-penida": {
        "image": "semabu-hills.jpg",
        "harbor_distance": "12 minutes from Banjar Nyuh harbor",
        "description": (
            "<p>High on the green slopes above Ped, <strong>Semabu Hills Hotel</strong> trades beachfront bustle for jungle calm. Rooms open "
            "onto tropical gardens and the hotel&rsquo;s signature tiered pools, with views over the coconut groves to the sea and, on clear "
            "mornings, to Mount Agung on Bali.</p>"
            "<p>It is a peaceful base for exploring the east of the island — Atuh Beach, the Thousand Islands viewpoint, the Tree House and "
            "the cave temple of Goa Giri Putri — while our kitchen cooks Balinese family recipes with vegetables from the hotel garden.</p>"
            "<ul><li>Tiered jungle pools with daybeds</li><li>Hillside rooms with garden terraces</li>"
            "<li>Driver and scooter rental for the east-coast loop</li></ul>"
        ),
        "gallery": [
            {"image": "semabu/sunrise-infinity-pool.jpg", "alt": "Infinity pool at sunrise with volcano view"},
            {"image": "jungle-pool.jpg", "alt": "Garden pool facing the rice fields"},
            {"image": "semabu/cascading-pool.jpg", "alt": "Cascading jungle pools"},
            {"image": "semabu/daybed-pool.jpg", "alt": "Poolside daybed in the garden"},
            {"image": "semabu/treehouse-deck.jpg", "alt": "Tree House deck overlooking Atuh coast"},
            {"image": "semabu/treehouse-view.jpg", "alt": "Thousand Islands viewpoint nearby"},
        ],
        "highlights": [
            {"title": "Tiered jungle pools", "body": "Three spring-fed pools step down the hillside, each with daybeds shaded by frangipani and banana palms."},
            {"title": "Cool hillside breezes", "body": "At 150 metres above the sea, evenings are fresh enough to sleep with the doors open to the garden."},
            {"title": "Gateway to the east coast", "body": "Atuh Beach, Diamond Beach and the Tree House are a scenic 45-minute drive — we arrange early starts to beat the crowds."},
            {"title": "Garden-to-table kitchen", "body": "Try betutu chicken, urab salad and fresh sambal made with herbs and chilies from the hotel garden."},
        ],
        "policies": GOOD_TO_KNOW("From 2:00 PM", "Until 11:00 AM", "Included, Balinese or continental",
                                 "Pick-up from Banjar Nyuh or Toya Pakeh (IDR 100,000 per car)", "Welcome; extra bed IDR 250,000",
                                 "The access road is steep — book our driver for luggage"),
        "nearby": [
            {"name": "Pura Dalem Ped Temple", "distance": "10 min drive"},
            {"name": "Banjar Nyuh Harbor", "distance": "12 min drive"},
            {"name": "Goa Giri Putri Cave Temple", "distance": "30 min drive"},
            {"name": "Atuh Beach & Diamond Beach", "distance": "45 min drive"},
            {"name": "Tree House Molenteng", "distance": "45 min drive"},
        ],
        "rooms": {
            "Deluxe Ocean Room": {"image": "bedroom-ocean.jpg"},
            "Private Pool Villa": {"image": "jungle-pool.jpg"},
        },
    },
    "batu-karang-lembongan-resort": {
        "image": "batu-karang-lembongan.jpg",
        "harbor_distance": "5 minutes from Jungutbatu beach landing",
        "description": (
            "<p>Perched on the limestone cliffs above Jungutbatu, <strong>Batu Karang Lembongan Resort</strong> looks out over the surf "
            "breaks of Nusa Lembongan to the peaks of Bali. Terraced suites, an adults-friendly cliff pool and a laid-back bar make it the "
            "island&rsquo;s classic sunset spot.</p>"
            "<p>Fast boats from Sanur land on the beach just below, so you can be in the pool within minutes of arriving. Rent a bicycle to "
            "cross the Yellow Bridge to Ceningan, paddle through the mangroves at dawn, or watch the waves explode at Devil&rsquo;s Tear "
            "before dinner on the terrace.</p>"
            "<ul><li>Cliff-top pool and sunset bar</li><li>Ocean-view suites with private terraces</li>"
            "<li>Bicycles, kayaks and snorkel gear free for guests</li></ul>"
        ),
        "gallery": [
            {"image": "batu-karang/cliff-resort.jpg", "alt": "Cliff-top resort above the ocean"},
            {"image": "batu-karang/coastline.jpg", "alt": "Lembongan coastline from the resort"},
            {"image": "batu-karang/ocean-cliffs.jpg", "alt": "Ocean cliffs framed by trees"},
            {"image": "batu-karang/garden-view.jpg", "alt": "Garden terrace overlooking the beach"},
            {"image": "batu-karang/cliff-lounge.jpg", "alt": "Cliff lounge above the water"},
        ],
        "highlights": [
            {"title": "The best sunset on Lembongan", "body": "The cliff bar faces due west — the sun sets behind Bali’s volcanoes every evening of the dry season."},
            {"title": "Beach landing below", "body": "Fast boats from Sanur arrive at Jungutbatu beach, a five-minute ride from reception with free luggage carry."},
            {"title": "Free bikes and kayaks", "body": "Cycle the coast road to the Yellow Bridge and Ceningan or kayak the calm lagoon at high tide."},
            {"title": "Surf and snorkel at the door", "body": "Shipwrecks, Lacerations and Playgrounds breaks are just offshore, with a reef for snorkeling at low tide."},
        ],
        "policies": GOOD_TO_KNOW("From 2:00 PM", "Until 12:00 PM", "Included, served on the cliff terrace",
                                 "Free pick-up from Jungutbatu beach landing", "Children 12+ recommended (cliff-edge pool)",
                                 "Wear water shoes — boats land directly on the beach"),
        "nearby": [
            {"name": "Jungutbatu Beach Landing", "distance": "5 min drive"},
            {"name": "Mangrove Forest", "distance": "10 min drive"},
            {"name": "Devil's Tear", "distance": "15 min drive"},
            {"name": "Yellow Bridge to Ceningan", "distance": "15 min drive"},
            {"name": "Dream Beach", "distance": "15 min drive"},
        ],
        "rooms": {
            "Deluxe Ocean Room": {"image": "suite-terrace.jpg"},
            "Private Pool Villa": {"image": "room-villa.png"},
        },
    },
}
