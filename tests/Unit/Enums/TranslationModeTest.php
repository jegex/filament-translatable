<?php

use Jegex\FilamentTranslatable\Enums\TranslationMode;

it('has spatie and astrotomic cases', function () {
    expect(TranslationMode::cases())->toHaveCount(2)
        ->and(TranslationMode::Spatie)->toBeInstanceOf(TranslationMode::class)
        ->and(TranslationMode::Astrotomic)->toBeInstanceOf(TranslationMode::class);
});

it('has correct enum names', function () {
    expect(TranslationMode::Spatie->name)->toBe('Spatie')
        ->and(TranslationMode::Astrotomic->name)->toBe('Astrotomic');
});
