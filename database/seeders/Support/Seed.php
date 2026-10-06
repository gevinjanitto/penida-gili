<?php

namespace Database\Seeders\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

/**
 * "Fill, never overwrite" seeding.
 *
 * Creates the row when it is missing; when it already exists only the attributes
 * that are still blank (null, '' or an empty list) are filled in. Content edited in
 * the admin console is therefore never replaced, but databases created by an older
 * version of the app still receive the photos, copy and sailings added later.
 */
final class Seed
{
    public static function fill(Builder|Relation $query, array $keys, array $values = []): Model
    {
        $model = (clone $query)->where($keys)->first();

        if (! $model) {
            return $query->create($keys + $values);
        }

        foreach ($values as $attribute => $value) {
            if (self::blank($model->getAttribute($attribute))) {
                $model->setAttribute($attribute, $value);
            }
        }

        if ($model->isDirty()) {
            $model->save();
        }

        return $model;
    }

    private static function blank(mixed $value): bool
    {
        return $value === null
            || $value === ''
            || $value === []
            || ($value instanceof Collection && $value->isEmpty());
    }
}
