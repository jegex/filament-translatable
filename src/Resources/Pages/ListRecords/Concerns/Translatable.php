<?php

namespace Jegex\FilamentTranslatable\Resources\Pages\ListRecords\Concerns;

use Jegex\FilamentTranslatable\Resources\Concerns\HasActiveLocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use RuntimeException;

trait Translatable
{
    use HasActiveLocaleSwitcher;

    public function bootTranslatable(): void
    {
        throw_unless(
            is_subclass_of(static::class, ListRecords::class),
            new RuntimeException('dont use the trait "' . Translatable::class . '" with "' . static::class . '"')
        );
    }

    public function mountTranslatable(): void
    {
        $this->activeLocale = filament('filament-translatable')->getDefaultLocale();
    }

    public function getActiveTableLocale(): ?string
    {
        return $this->activeLocale;
    }
}