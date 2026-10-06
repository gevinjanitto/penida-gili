<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'tagline', 'description', 'image', 'sort_order', 'is_active'])]
class Location extends Model
{
    use HasSlug;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected function slugSource(): string
    {
        return $this->name;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function ports(): HasMany
    {
        return $this->hasMany(Port::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function ordered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => ImagePath::url($this->image, 'locations'));
    }
}
