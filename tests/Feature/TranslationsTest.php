<?php

use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Jegex\FilamentTranslatable\Dto\Locale;
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;

it('can be instantiated', function () {
    $component = Translations::make('translations');

    expect($component)->toBeInstanceOf(Translations::class);
});

it('extends Repeater component', function () {
    $component = Translations::make('translations');

    expect($component)->toBeInstanceOf(\Filament\Forms\Components\Repeater::class);
});

it('has correct view', function () {
    $component = Translations::make('translations');

    expect($component->getView())->toBe('filament-translatable::forms.components.translatable');
});

it('defaults to default locale state', function () {
    $component = Translations::make('translations')
        ->defaultLocale('en');

    // After state hydrated, it should have default locale
    expect($component->getDefaultLocale())->toBe('en');
});

it('can set and get default locale', function () {
    $component = Translations::make('translations')
        ->defaultLocale('fr');

    expect($component->getDefaultLocale())->toBe('fr');
});

it('inherits default locale from plugin when not set', function () {
    $component = Translations::make('translations');

    expect($component->getDefaultLocale())->toBe('en'); // From TestCase setup
});

it('can set and get locales', function () {
    $component = Translations::make('translations')
        ->locales(['en', 'id']);

    $locales = $component->getLocales();

    expect($locales)->toHaveCount(2)
        ->and($locales[0]->code)->toBe('en')
        ->and($locales[1]->code)->toBe('id');
});

it('can set locales with associative array', function () {
    $component = Translations::make('translations')
        ->locales(['en' => 'English', 'id' => 'Bahasa Indonesia']);

    $locales = $component->getLocales();

    expect($locales)->toHaveCount(2)
        ->and($locales[0]->code)->toBe('en')
        ->and($locales[0]->label)->toBe('English')
        ->and($locales[1]->code)->toBe('id')
        ->and($locales[1]->label)->toBe('Bahasa Indonesia');
});

it('can set and get translation mode', function () {
    $component = Translations::make('translations')
        ->translationMode(TranslationMode::Astrotomic);

    expect($component->getTranslationMode())->toBe(TranslationMode::Astrotomic);
});

it('inherits translation mode from plugin when not set', function () {
    $component = Translations::make('translations');

    expect($component->getTranslationMode())->toBe(TranslationMode::Spatie);
});

it('can set exclude locales', function () {
    $component = Translations::make('translations')
        ->exclude(['fr']);

    expect($component)->toBeInstanceOf(Translations::class);
});

it('can set locale labels', function () {
    $component = Translations::make('translations')
        ->localeLabels(['en' => 'English', 'id' => 'Indonesian']);

    expect($component)->toBeInstanceOf(Translations::class);
});

it('can set prefix locale label', function () {
    $component = Translations::make('translations')
        ->prefixLocaleLabel(true);

    expect($component)->toBeInstanceOf(Translations::class);
});

it('can set suffix locale label', function () {
    $component = Translations::make('translations')
        ->suffixLocaleLabel(true);

    expect($component)->toBeInstanceOf(Translations::class);
});

it('can set vertical layout', function () {
    $component = Translations::make('translations')
        ->vertical(true);

    expect($component->isVertical())->toBeTrue();
});

it('defaults to non-vertical layout', function () {
    $component = Translations::make('translations');

    expect($component->isVertical())->toBeFalse();
});

it('can set scrollable', function () {
    $component = Translations::make('translations')
        ->scrollable(false);

    expect($component->isScrollable())->toBeFalse();
});

it('defaults to scrollable', function () {
    $component = Translations::make('translations');

    expect($component->isScrollable())->toBeTrue();
});

it('is not collapsible', function () {
    $component = Translations::make('translations');

    expect($component->isCollapsible())->toBeFalse();
});

it('can get locale available options', function () {
    $component = Translations::make('translations')
        ->locales(['en', 'id', 'fr'])
        ->default(fn () => ['en' => []]);

    $component->rawState(['en' => []]);

    $available = $component->getLocaleAvailableOptions();

    expect($available)->toHaveCount(2)
        ->and(array_keys($available))->toContain('id', 'fr');
});

it('can get select locale component', function () {
    $component = Translations::make('translations')
        ->locales(['en' => 'English']);

    $select = $component->getSelectLocale();

    expect($select)->toBeInstanceOf(\Filament\Forms\Components\Select::class);
});

it('can get add action', function () {
    $component = Translations::make('translations');

    $action = $component->getAddAction();

    expect($action)->toBeInstanceOf(\Filament\Actions\Action::class);
});

it('can get clone action', function () {
    $component = Translations::make('translations');

    $action = $component->getCloneAction();

    expect($action)->toBeInstanceOf(\Filament\Actions\Action::class);
});

it('can get delete action', function () {
    $component = Translations::make('translations');

    $action = $component->getDeleteAction();

    expect($action)->toBeInstanceOf(\Filament\Actions\Action::class);
});

it('can get locale label with flag', function () {
    $component = Translations::make('translations')
        ->displayFlagsInLocaleLabels(true)
        ->displayNamesInLocaleLabels(true);

    $locale = new Locale('en', 'English');
    $label = $component->getLocaleLabel($locale);

    expect($label)->toBeString();
});

it('can get locale label without flag', function () {
    $component = Translations::make('translations')
        ->displayFlagsInLocaleLabels(false)
        ->displayNamesInLocaleLabels(true);

    $locale = new Locale('en', 'English');
    $label = $component->getLocaleLabel($locale, false);

    expect($label)->toBe('English');
});

it('has flags in locale labels', function () {
    $component = Translations::make('translations')
        ->displayFlagsInLocaleLabels(true);

    expect($component->hasFlagsInLocaleLabels())->toBeTrue();
});

it('has names in locale labels', function () {
    $component = Translations::make('translations')
        ->displayNamesInLocaleLabels(true);

    expect($component->hasNamesInLocaleLabels())->toBeTrue();
});

it('can get flag width', function () {
    $component = Translations::make('translations')
        ->flagWidth('32px');

    expect($component->getFlagWidth())->toBe('32px');
});

it('inherits flag width from plugin when not set', function () {
    $component = Translations::make('translations');

    expect($component->getFlagWidth())->toBe('24px');
});

it('can get active tab', function () {
    $component = Translations::make('translations')
        ->locales(['en', 'id']);

    $activeTab = $component->getActiveTab();

    expect($activeTab)->not->toBeNull();
});
