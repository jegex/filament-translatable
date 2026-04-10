<?php

namespace Jegex\FilamentTranslatable\Resources\Concerns;

use Filament\Support\Contracts\TranslatableContentDriver;
use Jegex\FilamentTranslatable\AstrotomicTranslatableContentDriver;
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\SpatieTranslatableContentDriver;

trait HasActiveLocaleSwitcher
{
    public ?string $activeLocale = null;

    public function getActiveSchemaLocale(): ?string
    {
        if (! in_array($this->activeLocale, array_keys($this->getTranslatableLocales()), true)) {
            return null;
        }

        return $this->activeLocale;
    }

    public function getActiveActionsLocale(): ?string
    {
        return $this->activeLocale;
    }

    /**
     * @return class-string<TranslatableContentDriver> | null
     */
    public function getFilamentTranslatableContentDriver(): ?string
    {
        /** @var FilamentTranslatablePlugin $plugin */
        $plugin = filament('filament-translatable');

        return match ($plugin->getTranslationMode()) {
            TranslationMode::Spatie => SpatieTranslatableContentDriver::class,
            TranslationMode::Astrotomic => AstrotomicTranslatableContentDriver::class,
        };
    }

    public static function getTranslatableLocales(): array
    {
        /** @var FilamentTranslatablePlugin $plugin */
        $plugin = filament('filament-translatable');

        return $plugin->getLocales();
    }
}
