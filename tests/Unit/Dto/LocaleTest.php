<?php

use Jegex\FilamentTranslatable\Dto\Locale;

it('can create locale with code only', function () {
    $locale = new Locale('en');

    expect($locale->code)->toBe('en')
        ->and($locale->label)->toBe('en')
        ->and($locale->flag)->toBe('vendor/filament-translatable/flags/en.svg');
});

it('can create locale with custom label', function () {
    $locale = new Locale('en', 'English');

    expect($locale->code)->toBe('en')
        ->and($locale->label)->toBe('English')
        ->and($locale->flag)->toBe('vendor/filament-translatable/flags/en.svg');
});

it('can create locale with custom flag', function () {
    $locale = new Locale('en', flag: 'custom/flag.svg');

    expect($locale->code)->toBe('en')
        ->and($locale->label)->toBe('en')
        ->and($locale->flag)->toBe('custom/flag.svg');
});

it('can create locale with all parameters', function () {
    $locale = new Locale('id', 'Indonesian', 'custom/id.svg');

    expect($locale->code)->toBe('id')
        ->and($locale->label)->toBe('Indonesian')
        ->and($locale->flag)->toBe('custom/id.svg');
});
