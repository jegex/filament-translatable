<?php

use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

it('uses fallback locale when default not set', function () {
    config(['app.fallback_locale' => 'es']);

    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDefaultLocale())->toBe('es');
});

it('uses configured default locale when set', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->defaultLocale('fr');

    expect($plugin->getDefaultLocale())->toBe('fr');
});
