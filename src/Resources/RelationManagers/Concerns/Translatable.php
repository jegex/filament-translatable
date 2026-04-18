<?php

namespace Jegex\FilamentTranslatable\Resources\RelationManagers\Concerns;

use Jegex\FilamentTranslatable\Resources\Concerns\HasActiveLocaleSwitcher;

trait Translatable
{
    use HasActiveLocaleSwitcher;

    public function mountTranslatable(): void
    {
        $this->activeLocale = filament('filament-translatable')->getDefaultLocale();
    }

    public function getActiveTableLocale(): ?string
    {
        return $this->activeLocale;
    }
}
