<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'area', 'location_id'])]
class Port extends Model
{
    use HasFactory, HasSlug;

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function departingRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'origin_port_id');
    }

    public function arrivingRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'destination_port_id');
    }
}
