"""Source for catalogue-v2.json (articles). Bodies use the article editor's HTML subset."""


def img(src, alt):
    return f'<img src="/images/{src}" alt="{alt}">'


def h2(t):
    return f"<h2>{t}</h2>"


def p(t):
    return f"<p>{t}</p>"


def ul(*items):
    return "<ul>" + "".join(f"<li>{i}</li>" for i in items) + "</ul>"


def quote(t):
    return f"<blockquote>{t}</blockquote>"


ARTICLES = {
    "top-7-unmissable-snorkeling-spots-around-nusa-penida-gili-meno": {
        "read_time_minutes": 8,
        "hero_alt": "Manta rays gliding over a coral reef off Nusa Penida",
        "body": "".join([
            p("From manta cleaning stations to turtle meadows, the reefs between Bali and Lombok are some of the richest in the Coral Triangle. These are the seven spots our captains and guides recommend most, with tips on when to go and who each one suits."),
            h2("1. Manta Point, Nusa Penida"),
            p("Reef mantas with wingspans of up to four metres visit this cleaning station almost every day of the year. Small wrasse pick parasites off their wings while snorkelers float above. Conditions can be choppy, so book a morning trip and bring a long-sleeve rash guard."),
            img("activities/detail/snorkel/manta-below.jpg", "Manta ray seen from below at Manta Point"),
            ul("<strong>Best for:</strong> confident swimmers", "<strong>Best time:</strong> 8:00–11:00 AM", "<strong>Getting there:</strong> 35 minutes by boat from Toya Pakeh"),
            h2("2. Crystal Bay, Nusa Penida"),
            p("A calm, sheltered bay on the west coast with excellent visibility, colourful hard corals and the chance of spotting the mola-mola (ocean sunfish) between July and October. You can snorkel straight from the beach."),
            h2("3. Gamat Bay, Nusa Penida"),
            p("Gentle slopes, schooling fish and a fringing reef in pristine condition make Gamat Bay perfect for beginners and families. Look for parrotfish, moorish idols and the occasional reef shark resting on the sand."),
            h2("4. Mangrove Point, Nusa Lembongan"),
            ul("Best for drift snorkeling on an incoming tide.", "Look out for turtles, batfish and giant clams.", "Only 30 minutes by fast boat from Sanur."),
            img("activities/detail/snorkel/reef-fish.jpg", "Coral reef with tropical fish at Mangrove Point"),
            h2("5. Turtle Point, Gili Trawangan"),
            p("Green and hawksbill turtles graze on the seagrass just off the north-east coast. Swim out from the beach or join a glass-bottom boat tour — and remember to give the turtles plenty of space."),
            img("activities/detail/turtle/green-turtle.jpg", "Green sea turtle swimming at Turtle Point"),
            h2("6. Nest Statues, Gili Meno"),
            p("Forty-eight life-size statues by Jason deCaires Taylor sit in four metres of water and are slowly becoming a living reef. Visit early in the morning for clear water and fewer boats."),
            h2("7. Toyapakeh Wall, Nusa Penida"),
            p("Strong currents bring nutrients that feed huge sea fans and soft corals. This is a site for confident swimmers with a guide; the boat follows you as you drift along the wall."),
            h2("Snorkeling etiquette"),
            ul("Wear reef-safe sunscreen or a rash guard instead.", "Never stand on, touch or kick the coral.", "Keep at least three metres from mantas and turtles.", "Book licensed operators who brief you before every swim."),
            quote("Always book licensed operators, wear reef-safe sunscreen and never touch the coral or the wildlife."),
        ]),
    },
    "best-time-of-day-for-calm-waters-crossing-the-badung-strait-comfortably": {
        "read_time_minutes": 6,
        "hero_alt": "Fast boat crossing the calm Badung Strait at sunrise",
        "body": "".join([
            p("The Badung Strait between Bali and Nusa Penida is only 20 kilometres wide, but it is one of the deepest channels in Indonesia. Water from the Pacific flows through it into the Indian Ocean, so tides, wind and swell can change the feel of your crossing completely. Here is how our captains choose the smoothest sailing."),
            h2("Why mornings are calmer"),
            p("Before the sea breeze builds, the surface of the strait is usually glassy. Most days the wind picks up after 11:00 AM and creates short, choppy waves. Departing between 7:00 and 9:00 AM gives you the calmest water and the best light for photos."),
            img("articles/content/fastboat-sanur.jpg", "Fast boat waiting at Sanur with Mount Agung behind"),
            h2("Reading the tide"),
            p("When the tide runs against the wind, waves stand up and the ride gets bumpy. Captains plan departures around slack tide where possible. You do not need to read tide tables yourself — but if you are sensitive to motion, ask us which departure has the most favourable tide that day."),
            h2("Seasons and swell"),
            ul("<strong>April–October (dry season):</strong> steady south-east trade winds; mornings calm, afternoons choppy.", "<strong>November–March (wet season):</strong> lighter winds but occasional storms; crossings are often smoother outside rain squalls.", "<strong>Big swell days:</strong> boats may land on the sheltered side of the island or delay departures for safety."),
            h2("Where to sit"),
            p("Choose a seat in the middle of the boat and near the back, where movement is gentlest. Keep your eyes on the horizon, avoid reading your phone and step outside for fresh air if the crew allows it."),
            img("articles/content/boat-aerial.jpg", "Speedboat over turquoise water seen from above"),
            h2("Beating seasickness"),
            ul("Eat a light breakfast — an empty stomach makes nausea worse.", "Take ginger candy or motion-sickness tablets 30 minutes before boarding.", "Sit facing forward and stay hydrated.", "Book a larger catamaran on windy days."),
            quote("The best crossing is an early one: book the first or second departure of the day and you will usually arrive before the wind does."),
        ]),
    },
    "kelingking-t-rex-cliff-diamond-beach-how-to-plan-your-day-trip": {
        "read_time_minutes": 7,
        "hero_alt": "Kelingking T-Rex cliff above the turquoise sea",
        "body": "".join([
            p("Kelingking’s T-Rex shaped headland and the white sand of Diamond Beach are Nusa Penida’s two most famous views — and they sit on opposite sides of the island. With an early boat and a good driver, you can see both in a single, unhurried day."),
            h2("Morning: catch the first boat"),
            p("Take the 7:00 or 7:30 AM fast boat from Sanur and you will land at Toya Pakeh or Banjar Nyuh before 8:30 AM. Arrange your driver in advance — they will be waiting at the harbor with your name."),
            h2("Kelingking first"),
            p("The drive to Kelingking takes about 50 minutes on narrow roads. Arriving before 10:00 AM means softer light, cooler temperatures and far fewer people on the viewpoint. The famous photo spot is a two-minute walk from the car park."),
            img("activities/detail/kelingking/aerial.jpg", "Kelingking headland seen from above"),
            h2("Should you hike down?"),
            ul("The trail to the beach is steep, partly bamboo railings and takes 30–40 minutes each way.", "Wear proper shoes and bring at least one litre of water.", "Swimming is dangerous because of strong waves — enjoy the sand, not the surf."),
            h2("Lunch on the way east"),
            p("Stop at one of the warungs near Pejukutan for nasi campur and fresh juice. The drive across the island takes about 75 minutes and passes through villages, cashew farms and hills with views of Mount Agung."),
            h2("Afternoon: Diamond Beach"),
            p("A staircase carved into the cliff leads down to Diamond Beach, framed by sharp limestone pinnacles. The light is beautiful in the afternoon, and neighbouring Atuh Beach is a short walk away for a swim in calmer water."),
            img("articles/content/diamond-beach.jpg", "Diamond Beach and its limestone pinnacles"),
            img("articles/content/diamond-beach-rocks.jpg", "Rock formations along the Diamond Beach coastline"),
            h2("Getting back"),
            p("Leave Diamond Beach by 3:30 PM to catch a 4:30 or 5:00 PM boat back to Sanur. If you would rather not rush, spend the night at a hotel in the east and visit the Tree House at sunrise."),
            quote("Book your driver and the return boat before you go — on busy days the last departures sell out."),
        ]),
    },
    "choosing-between-fast-ferry-vs-speedboat-comfort-speed-price-comparison": {
        "read_time_minutes": 7,
        "hero_alt": "Fast ferry and speedboat at a Bali harbor",
        "body": "".join([
            p("All fast boats to the islands look similar from the beach, but the ride can be very different. Here is how the main types compare on comfort, speed and price so you can choose the right crossing for your trip."),
            h2("Large catamarans"),
            p("Twin hulls make catamarans the most stable option, especially on windy afternoons. They carry 100–200 passengers, have air-conditioned cabins and toilets, and usually board from a pier, so you keep your feet dry."),
            ul("<strong>Crossing time:</strong> 40–50 minutes to Nusa Penida", "<strong>Best for:</strong> families, motion-sensitive travelers, lots of luggage"),
            h2("Mono-hull fast boats"),
            p("The most common boats on the Sanur routes. They are quick, frequent and good value, with indoor seats and an open deck at the back. On choppy days the ride feels livelier than on a catamaran."),
            img("articles/content/boat-passengers.jpg", "Passengers on the deck of a fast boat"),
            h2("Speedboats"),
            p("Smaller boats with powerful outboard engines and 30–60 seats. They are the fastest way to cross and often land directly on the beach, which means wading in knee-deep water. Expect a bumpy, exciting ride."),
            img("articles/content/speedboat-beach.jpg", "Speedboat anchored off the beach"),
            h2("Public slow ferry"),
            p("The Ro-Ro car ferry from Padang Bai is the cheapest option and carries cars and motorbikes, but it takes around two hours and departure times can change at short notice."),
            h2("Price comparison"),
            ul("Public ferry: from IDR 35,000 one way", "Speedboat or mono-hull: IDR 150,000–250,000 one way", "Catamaran: IDR 250,000–400,000 one way", "Return tickets and hotel transfers are often bundled at a discount."),
            h2("Our recommendation"),
            p("Choose a catamaran for comfort, a mono-hull for value and frequent departures, and a speedboat if you want to arrive quickly and do not mind getting your feet wet. Whatever you pick, book the morning departures for the calmest water."),
            quote("Penida Gili lists every operator with its vessel type, capacity and boarding style, so you know exactly what you are booking."),
        ]),
    },
    "what-to-pack-for-an-island-getaway-to-nusa-lembongan-and-ceningan": {
        "read_time_minutes": 6,
        "hero_alt": "Yellow Bridge between Nusa Lembongan and Ceningan",
        "body": "".join([
            p("Many boats to Nusa Lembongan land directly on Jungutbatu beach, roads are narrow and the sun is strong. Packing light and smart makes the whole trip easier. This is our checklist."),
            h2("The bag itself"),
            p("A soft backpack or duffel is far easier than a rolling suitcase on sand and stairs. Keep it under 15 kg so the crew can pass it from boat to beach, and use a dry bag or plastic liner for your electronics."),
            img("articles/content/backpack.jpg", "Compact travel backpack ready for the island"),
            h2("Clothes"),
            ul("Two swimsuits so one can always dry.", "Light, quick-dry shorts and shirts.", "A sarong — beach towel, cover-up and temple wear in one.", "One long-sleeve layer for the boat and the evening breeze."),
            h2("Shoes"),
            p("Bring sandals or water shoes you can wade in for the beach landing, plus a pair of trainers if you plan to hike to Kelingking or cycle across the Yellow Bridge to Ceningan."),
            h2("Sun and sea"),
            ul("Reef-safe sunscreen (SPF 50) and a hat.", "Polarised sunglasses for spotting turtles and mantas.", "Your own snorkel mask if you are fussy about fit.", "A rash guard for long snorkel trips."),
            img("articles/content/beach-gear.jpg", "Beach gear laid out on the sand"),
            h2("Money and documents"),
            p("ATMs on Lembongan sometimes run out of cash, so bring enough rupiah for small warungs and scooter rental. Keep a photo of your passport and your boat tickets on your phone."),
            h2("Little extras"),
            ul("Motion-sickness tablets or ginger candy for the crossing.", "A reusable water bottle — refill stations are everywhere.", "Insect repellent for the mangroves at dusk.", "A headlamp; some lanes have no street lights."),
            img("articles/content/pier-bali.jpg", "Traveler on a pier looking over the turquoise sea"),
            quote("Pack half the clothes you think you need — island days are spent in a swimsuit."),
        ]),
    },
    "balinese-cultural-etiquette-visiting-pura-goa-giri-putri-and-sacred-temples": {
        "read_time_minutes": 6,
        "hero_alt": "Worshippers entering Pura Goa Giri Putri cave temple",
        "body": "".join([
            p("Pura Goa Giri Putri is a Hindu temple hidden inside a limestone cave on Nusa Penida’s east coast. Visitors are warmly welcomed, but temples are active places of worship. These simple customs show respect to the community and make your visit more meaningful."),
            h2("Dress code"),
            ul("Wear a sarong (<em>kamen</em>) and a sash (<em>selendang</em>) — both are available to borrow at the entrance.", "Cover your shoulders; a T-shirt is fine.", "Remove hats and sunglasses inside the temple courtyards."),
            img("activities/detail/adat/procession.jpg", "Balinese women in traditional dress at a temple procession"),
            h2("Entering the cave"),
            p("The entrance to Goa Giri Putri is a narrow gap in the rock reached by a stairway of about 110 steps. Inside, the cave opens into a vast hall with shrines for Hindu, Buddhist and Chinese deities. A priest will bless you with holy water and rice at the entrance."),
            h2("Behaviour inside temples"),
            ul("Speak quietly and never climb on shrines or walls.", "Do not walk in front of people who are praying.", "Ask before taking photos of priests or ceremonies; flash is not allowed.", "Women who are menstruating are asked not to enter, by local custom."),
            img("activities/detail/adat/temple-prayer.jpg", "Woman praying with incense in Balinese dress"),
            h2("Offerings"),
            p("You will see small woven trays called <em>canang sari</em> on doorsteps, shrines and even boats. Take care not to step on them. If you would like to make your own offering, the temple guardian can sell you one at the entrance."),
            img("articles/content/penjor.jpg", "Decorated penjor bamboo pole for a ceremony"),
            h2("Donations"),
            p("Entry is by donation. IDR 20,000–50,000 per person is customary and helps maintain the temple; place it in the donation box or hand it to the guardian."),
            h2("Other sacred places on Nusa Penida"),
            ul("<strong>Pura Dalem Ped</strong> — the island’s most important sea temple near Ped village.", "<strong>Pura Paluang</strong> — the “car temple” in the hills, with shrines shaped like vehicles.", "<strong>Pura Segara Kidul</strong> — a small cliff temple above Banah."),
            quote("A sarong, a smile and a small donation are all you need to be welcome in any Balinese temple."),
        ]),
    },
}
