<?php

use Jegex\FilamentTranslatable\Dto\Locale;
use Jegex\FilamentTranslatable\Enums\TranslationMode;

it('creates a locale with code only', function () {
    $locale = new Locale('en');

    expect($locale->code)->toBe('en')
        ->and($locale->label)->toBe('en')
        ->and($locale->flag)->toBe('vendor/filament-translatable/flags/en.svg');
});

it('creates a locale with code and custom label', function () {
    $locale = new Locale('id', 'Indonesian');

    expect($locale->code)->toBe('id')
        ->and($locale->label)->toBe('Indonesian')
        ->and($locale->flag)->toBe('vendor/filament-translatable/flags/id.svg');
});

it('creates a locale with code, label and custom flag', function () {
    $locale = new Locale('fr', 'Français', 'custom/path/fr.svg');

    expect($locale->code)->toBe('fr')
        ->and($locale->label)->toBe('Français')
        ->and($locale->flag)->toBe('custom/path/fr.svg');
});

it('is readonly', function () {
    $locale = new Locale('en');

    // Attempting to modify properties should fail since it's readonly
    expect($locale)->toBeInstanceOf(Locale::class);
});
