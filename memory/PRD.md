# Penida Gili — PRD / Work Log

## Original problem statement (2026-06)
Clone `github.com/gevinjanitto/penida-gili` and fix:
1. Photo 1 — "Ticket prices" (boat order summary) price text was cut off ("Rp 100.00").
2. Photo 2 — hotel/operator cards printed raw HTML tags (`<p>`, `<strong>`) as text.
3. "Book Now" should open WhatsApp with a pre-filled message (just tap send).
4. "Book With Email" should open email pre-filled (already did; preserved).
5. Admin: add a category (Boat / Activity / Hotel) + a filter.
Constraint: don't change anything else.

## Stack
- Laravel 13 (PHP 8.4) + Blade + Vite/Tailwind v4, SQLite (preview).
- Served by supervisor program `laravel` → `php artisan serve` on port 3000.
- PHP/Composer/supervisor live outside /app → run `bash scripts/dev-setup.sh` after a pod restart.

## Implemented (2026-06)
- **Assets over HTTPS**: `AppServiceProvider` now forces https scheme + root URL whenever `APP_URL` is https (preview terminates TLS at the edge). Fixes mixed-content that blocked `app.js`.
- **Photo 1**: `partials/boat/fare-table.blade.php` — tightened padding, `tabular-nums`, smaller responsive price text so Domestic/Foreign Adult/Child fares fit on one line (no clipping).
- **Photo 2**: added `plain_description` accessor to `Hotel` and `BoatOperator` (mirrors `Activity`); cards now use `plain_description` in `pages/hotels`, `pages/boats`, `partials/home/operators`.
- **Book Now → WhatsApp**: `BookingQuote::whatsappHref()` builds a pre-filled `wa.me` link (server fallback); `resources/js/order-whatsapp.js` enriches it with live form values; all 6 "Book Now" CTAs (boat/hotel/activity × desktop/mobile) converted from submit buttons to `data-wa-book` anchors. Forms carry `data-whatsapp`.
- **Book With Email**: unchanged (already opens pre-filled Gmail compose).
- **Admin category + filter**: `Booking::category` accessor (Boat/Activity/Hotel); `ReportController` exposes `type` filter + category list; `route-filters` gained an optional Category dropdown (report only, not schedules); report table gained a Category column (coloured pill). Backend `BookingReport` already supported `type`.
- Seeded sample Activity (2) and Hotel (2) bookings so the category column/filter is demonstrable.

## Verified
- All public pages + `/admin/login` return 200.
- Hotel cards render clean text (no tags).
- Fare prices sit on one line (screenshot, desktop 1600px).
- Book Now/Book With Email render `wa.me` / Gmail links on boat, hotel, activity orders.
- Admin report (authenticated curl): Category column + dropdown present; `?type=hotel` → 2 hotel rows, `?type=activity` → 2 rows.

## Notes / backlog
- New bookings now flow through WhatsApp/Email, so the DB Booking table is historical/seeded only (admin report reads it).
- The brand-intro splash is a once-per-session loader (auto-dismisses ≤5s); unchanged.
