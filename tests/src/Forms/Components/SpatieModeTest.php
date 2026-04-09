<?php

use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\Tests\Forms\Fixtures\TestComponentWithTranslate;
use Jegex\FilamentTranslatable\Tests\TestCase;
use function Pest\Livewire\livewire;

uses(TestCase::class);

it('uses spatie translation mode by default', function (): void {
    $locales = ['en', 'fr'];

    $component = livewire(TestComponentWithTranslate::class, [
        'locales' => $locales,
        'exclude' => [],
    ]);

    $component->assertSchemaComponentExists('translations::data::tabs', checkComponentUsing: function ($translations): true {
        expect($translations->getTranslationMode())->toBe(TranslationMode::Spatie);

        return true;
    });
});
