<?php

namespace Jegex\FilamentTranslatable;

use Filament\Support\Contracts\TranslatableContentDriver;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use function Filament\Support\generate_search_column_expression;

class SpatieTranslatableContentDriver implements TranslatableContentDriver
{
    public function __construct(protected string $activeLocale) {}

    public function isAttributeTranslatable(string $model, string $attribute): bool
    {
        /** @var Model $model */
        $model = app($model);

        if (! in_array(HasTranslations::class, class_uses_recursive($model))) {
            return false;
        }

        return $model->isTranslatableAttribute($attribute);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function makeRecord(string $model, array $data): Model
    {
        /** @var Model $record */
        $record = new $model;

        $translatableAttributes = [];
        
        if (in_array(HasTranslations::class, class_uses_recursive($record))) {
            $translatableAttributes = $record->getTranslatableAttributes();
        }

        $translatableData = [];
        $nonTranslatableData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $translatableAttributes)) {
                $translatableData[$key] = $value;
            } else {
                $nonTranslatableData[$key] = $value;
            }
        }

        $record->fill($nonTranslatableData);

        foreach ($translatableData as $attribute => $value) {
            $record->setTranslation($attribute, $this->activeLocale, $value);
        }

        return $record;
    }

    public function setRecordLocale(Model $record): Model
    {
        // Spatie menyimpan semua locale dalam JSON, jadi tidak perlu set locale
        return $record;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateRecord(Model $record, array $data): Model
    {
        $translatableAttributes = [];
        
        if (in_array(HasTranslations::class, class_uses_recursive($record))) {
            $translatableAttributes = $record->getTranslatableAttributes();
        }

        $translatableData = [];
        $nonTranslatableData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $translatableAttributes)) {
                $translatableData[$key] = $value;
            } else {
                $nonTranslatableData[$key] = $value;
            }
        }

        $record->fill($nonTranslatableData);

        foreach ($translatableData as $attribute => $value) {
            $record->setTranslation($attribute, $this->activeLocale, $value);
        }

        $record->save();

        return $record;
    }

    /**
     * @return array<string, mixed>
     */
    public function getRecordAttributesToArray(Model $record): array
    {
        $attributes = $record->attributesToArray();

        if (! in_array(HasTranslations::class, class_uses_recursive($record))) {
            return $attributes;
        }

        $translatableAttributes = $record->getTranslatableAttributes();

        foreach ($translatableAttributes as $attribute) {
            $attributes[$attribute] = $record->getTranslation($attribute, $this->activeLocale);
        }

        return $attributes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAllTranslationsForAllLocales(Model $record): array
    {
        if (! in_array(HasTranslations::class, class_uses_recursive($record))) {
            return [];
        }

        $translatableAttributes = $record->getTranslatableAttributes();
        $translations = [];

        foreach ($translatableAttributes as $attribute) {
            $translations[$attribute] = $record->getTranslations($attribute);
        }

        return $translations;
    }

    public function applySearchConstraintToQuery(
        Builder $query,
        string $column,
        string $search,
        string $whereClause,
        ?bool $isCaseInsensitivityForced = null
    ): Builder {
        /** @var Connection $databaseConnection */
        $databaseConnection = $query->getConnection();

        $databaseConnection->getDriverName();

        return $query->{$whereClause}(
            generate_search_column_expression($column, $isCaseInsensitivityForced, $databaseConnection),
            'like',
            "%{$search}%",
        );
    }
}
