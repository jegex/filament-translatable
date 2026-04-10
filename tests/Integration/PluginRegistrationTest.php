<?php

use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

it('can create plugin instance', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin)->toBeInstanceOf(FilamentTranslatablePlugin::class)
        ->and($plugin->getId())->toBe('filament-translatable');
});

it('can configure plugin with fluent methods', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->locales(['en', 'id'])
        ->defaultLocale('en')
        ->displayFlagsInLocaleLabels(true)
        ->flagWidth('24px');

    expect($plugin->getLocales())->toBe(['en', 'id'])
        ->and($plugin->getDefaultLocale())->toBe('en')
        ->and($plugin->getDisplayFlagsInLocaleLabels())->toBeTrue()
        ->and($plugin->getFlagWidth())->toBe('24px');
});

it('plugin is registered in service container', function () {
    $plugin = app(FilamentTranslatablePlugin::class);

    expect($plugin)->toBeInstanceOf(FilamentTranslatablePlugin::class);
});
