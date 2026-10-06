<?php

namespace App\Providers;

use App\Enums\ListingStatus;
use App\Models\Location;
use App\Models\Port;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Railway/Emergent (and most PaaS) terminate TLS at the edge; keep generated URLs on https.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Console-managed settings (WhatsApp, email, social links) override the env defaults
        // everywhere, and every view gets them as $site.
        $site = Setting::all_values();
        config([
            'penida.booking.whatsapp' => preg_replace('/\D+/', '', $site['whatsapp']) ?: config('penida.booking.whatsapp'),
            'penida.booking.email' => $site['email'] ?: config('penida.booking.email'),
        ]);
        View::share('site', $site);

        // The hero search widget can be dropped on any page; it always needs the
        // port list (grouped by island) and the destination master list.
        View::composer('partials.search.widget', function ($view): void {
            static $data = null;

            $data ??= [
                'searchPorts' => Port::query()
                    ->with('location')
                    ->orderBy('name')
                    ->get()
                    ->groupBy(fn (Port $port) => $port->location?->name ?? ($port->area ?: 'Other'))
                    ->sortBy(fn ($ports) => $ports->first()->location?->sort_order ?? 999)
                    ->map(fn ($ports, $group) => ['group' => $group, 'ports' => $ports])
                    ->values(),
                'searchLocations' => Location::query()
                    ->active()
                    ->ordered()
                    ->withCount(['activities' => fn ($q) => $q->where('status', ListingStatus::Active)])
                    ->get(),
            ];

            $view->with($data);
        });
    }
}
