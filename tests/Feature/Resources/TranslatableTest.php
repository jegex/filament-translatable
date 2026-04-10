<?php

use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

beforeEach(function () {
    FilamentTranslatablePlugin::make()
        ->locales(['en', 'id', 'fr'])
        ->defaultLocale('en');
});

it('can get active table locale', function () {
    $page = new class {
        use Translatable;
    };

    $page->activeLocale = 'en';

    expect($page->getActiveTableLocale())->toBe('en');
});

it('returns null for invalid schema locale', function () {
    $page = new class {
        use Translatable;

        public function getTranslatableLocales(): array
        {
            return ['en' => 'English', 'id' => 'Indonesian'];
        }
    };

    $page->activeLocale = 'invalid';

    expect($page->getActiveSchemaLocale())->toBeNull();
});

it('returns locale for valid schema locale', function () {
    $page = new class {
        use Translatable;

        public function getTranslatableLocales(): array
        {
            return ['en' => 'English', 'id' => 'Indonesian', 'fr' => 'French'];
        }
    };

    $page->activeLocale = 'fr';

    expect($page->getActiveSchemaLocale())->toBe('fr');
});

it('can get active actions locale', function () {
    $page = new class {
        use Translatable;
    };

    $page->activeLocale = 'id';

    expect($page->getActiveActionsLocale())->toBe('id');
});
