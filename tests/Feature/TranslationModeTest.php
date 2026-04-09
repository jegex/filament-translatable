<?php

use Jegex\FilamentTranslatable\Enums\TranslationMode;

it('has Spatie case', function () {
    expect(TranslationMode::Spatie)->toBeInstanceOf(TranslationMode::class);
});

it('has Astrotomic case', function () {
    expect(TranslationMode::Astrotomic)->toBeInstanceOf(TranslationMode::class);
});

it('can be compared', function () {
    $mode = TranslationMode::Spatie;

    expect($mode)->toBe(TranslationMode::Spatie)
        ->and($mode)->not->toBe(TranslationMode::Astrotomic);
});

it('can be stringified', function () {
    expect((string) TranslationMode::Spatie)->toContain('Spatie')
        ->and((string) TranslationMode::Astrotomic)->toContain('Astrotomic');
});
