<?php

namespace Jegex\FilamentTranslatable\Actions;

use Filament\Actions\SelectAction;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

class LocaleSwitcher extends SelectAction
{
    public static function getDefaultName(): ?string
    {
        return 'activeLocale';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-translatable::active_locale.label'));
        $this->options(fn () => filament('filament-translatable')->getLocales());
    }
}
