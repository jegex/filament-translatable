<?php

use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

it('can be instantiated', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin)->toBeInstanceOf(FilamentTranslatablePlugin::class);
});

it('has correct id', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getId())->toBe('filament-translatable');
});

it('has spatie as default translation mode', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getTranslationMode())->toBe(TranslationMode::Spatie);
});

it('can set translation mode to astrotomic', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->translationMode(TranslationMode::Astrotomic);

    expect($plugin->getTranslationMode())->toBe(TranslationMode::Astrotomic);
});

it('can set translation mode back to spatie', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->translationMode(TranslationMode::Astrotomic)
        ->translationMode(TranslationMode::Spatie);

    expect($plugin->getTranslationMode())->toBe(TranslationMode::Spatie);
});

it('can set locales', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->locales(['en', 'id', 'fr']);

    expect($plugin->getLocales())->toBe(['en', 'id', 'fr']);
});

it('can set default locale', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->defaultLocale('en');

    expect($plugin->getDefaultLocale())->toBe('en');
});

it('uses fallback locale when default not set', function () {
    // This test needs to be in Feature tests to have access to config
    // Skipping in Unit tests
})->skip('Config access not available in unit tests. See Feature tests.');

it('can display flags in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->displayFlagsInLocaleLabels(true);

    expect($plugin->getDisplayFlagsInLocaleLabels())->toBeTrue();
});

it('can disable flags in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->displayFlagsInLocaleLabels(false);

    expect($plugin->getDisplayFlagsInLocaleLabels())->toBeFalse();
});

it('has flags disabled by default', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDisplayFlagsInLocaleLabels())->toBeFalse();
});

it('can display names in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->displayNamesInLocaleLabels(true);

    expect($plugin->getDisplayNamesInLocaleLabels())->toBeTrue();
});

it('has names enabled by default', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDisplayNamesInLocaleLabels())->toBeTrue();
});

it('can set flag width', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->flagWidth('32px');

    expect($plugin->getFlagWidth())->toBe('32px');
});
