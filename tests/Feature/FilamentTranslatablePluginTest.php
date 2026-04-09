<?php

use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\Enums\TranslationMode;

it('can be instantiated', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin)->toBeInstanceOf(FilamentTranslatablePlugin::class);
});

it('has correct id', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getId())->toBe('filament-translatable');
});

it('can set and get locales', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->locales(['en', 'id', 'fr']);

    expect($plugin->getLocales())->toBe(['en', 'id', 'fr']);
});

it('can set locales with closure', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->locales(fn () => ['es', 'de']);

    expect($plugin->getLocales())->toBe(['es', 'de']);
});

it('can set null locales', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->locales(null);

    expect($plugin->getLocales())->toBeNull();
});

it('can set and get default locale', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->defaultLocale('en');

    expect($plugin->getDefaultLocale())->toBe('en');
});

it('uses fallback for default locale when not set', function () {
    config(['app.fallback_locale' => 'fr']);

    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDefaultLocale())->toBe('fr');
});

it('can set and get translation mode', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->translationMode(TranslationMode::Astrotomic);

    expect($plugin->getTranslationMode())->toBe(TranslationMode::Astrotomic);
});

it('defaults to Spatie translation mode', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getTranslationMode())->toBe(TranslationMode::Spatie);
});

it('can display flags in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->displayFlagsInLocaleLabels(true);

    expect($plugin->getDisplayFlagsInLocaleLabels())->toBeTrue();
});

it('defaults to not displaying flags in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDisplayFlagsInLocaleLabels())->toBeFalse();
});

it('can display names in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->displayNamesInLocaleLabels(true);

    expect($plugin->getDisplayNamesInLocaleLabels())->toBeTrue();
});

it('defaults to displaying names in locale labels', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getDisplayNamesInLocaleLabels())->toBeTrue();
});

it('can set and get flag width', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->flagWidth('32px');

    expect($plugin->getFlagWidth())->toBe('32px');
});

it('can set flag width with closure', function () {
    $plugin = FilamentTranslatablePlugin::make()
        ->flagWidth(fn () => '48px');

    expect($plugin->getFlagWidth())->toBe('48px');
});

it('defaults to 24px flag width', function () {
    $plugin = FilamentTranslatablePlugin::make();

    expect($plugin->getFlagWidth())->toBe('24px');
});

it('can be retrieved using static get method', function () {
    $plugin = FilamentTranslatablePlugin::make();
    filament()->registerPlugin($plugin);

    $retrieved = FilamentTranslatablePlugin::get();

    expect($retrieved)->toBeInstanceOf(FilamentTranslatablePlugin::class);
});
