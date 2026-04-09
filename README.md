# Filament Translatable Spatie & Astrotomic

[![FILAMENT 4.x](https://img.shields.io/badge/FILAMENT-4.x-eb1631?style=flat-square)](https://filamentphp.com/docs/4.x/introduction/overview)
[![FILAMENT 5.x](https://img.shields.io/badge/FILAMENT-5.x-eb1631?style=flat-square)](https://filamentphp.com/docs/5.x/introduction/overview)
[![Packagist](https://img.shields.io/packagist/v/jegex/filament-translatable.svg?style=flat-square)](https://packagist.org/packages/jegex/filament-translatable)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jegex/filament-translatable/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jegex/filament-translatable/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Downloads](https://img.shields.io/packagist/dt/jegex/filament-translatable.svg?style=flat-square)](https://packagist.org/packages/jegex/filament-translatable)

**Filament Translatable** is a flexible package that provides a complete solution for managing multilingual content in [Filament](https://filamentphp.com) admin panels. It uses a tabbed interface with **Repeater** component, allowing you to easily create translatable form fields with an intuitive UI.

## Key Features

- **Tab-Based UI with Repeater** — extends Filament Repeater, leveraging all Repeater features
- **Locale Tabs with Flags** — horizontal or vertical tabs with 200+ built-in SVG flags
- **Clone Locale** — duplicate translations between locales
- **Multiple Translation Backends** — supports both [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable) and [astrotomic/laravel-translatable](https://github.com/astrotomic/laravel-translatable)
- **Flexible Locale Configuration** — define locales globally or per-component
- **Vertical & Horizontal Tabs** — choose your preferred layout
- **Scrollable Tabs** — for managing many languages

## Installation

You can install the package via composer:

```bash
composer require jegex/filament-translatable
```

Publish the assets:

```bash
php artisan filament:assets
```

## Configuration

### With `spatie/laravel-translatable`

The [Spatie](https://github.com/spatie/laravel-translatable) package is the default translation backend. Follow the instructions in the [Spatie documentation](https://github.com/spatie/laravel-translatable/?tab=readme-ov-file#a-trait-to-make-eloquent-models-translatable) to properly configure your models.

### With `astrotomic/laravel-translatable`

The [Astrotomic](https://github.com/astrotomic/laravel-translatable) package is an alternative translation backend.

Follow the [Astrotomic documentation](https://docs.astrotomic.info/laravel-translatable/installation#models) to configure your models.

When using the Astrotomic package, configure the plugin to use Astrotomic mode:

```php
use Jegex\FilamentTranslatable\Enums\TranslationMode;

FilamentTranslatablePlugin::make()
    ->translationMode(TranslationMode::Astrotomic)
```

## Setup

```php
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentTranslatablePlugin::make());
}
```

### Setting translatable locales

To set up the locales that can be used to translate content, pass an array of locales to the `locales()` plugin method:

```php
FilamentTranslatablePlugin::make()
    ->locales(['en', 'id', 'fr', 'de']),
```

You can set locale labels using key => value array:

```php
FilamentTranslatablePlugin::make()
    ->locales([
        'en' => __('('English'),
        'id' => __('Indonesian'),
        'fr' => __('French'),
    ])
```

Also, you can pass a Closure:

```php
FilamentTranslatablePlugin::make()
    ->locales(fn () => Language::pluck('code', 'name'))
```

### Setting default locale

You can set the default locale using the `defaultLocale()` method:

```php
FilamentTranslatablePlugin::make()
    ->defaultLocale('en'),
```

### Enable or disable flags in locale labels

You can enable or disable flags in locale labels (disabled by default):

```php
FilamentTranslatablePlugin::make()
    ->displayFlagsInLocaleLabels(true)
```

### Setting flag width

You can set the flag width using:

```php
FilamentTranslatablePlugin::make()
    ->flagWidth('24px')
```

## Usage

### Basic Usage

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

Translations::make('translations')
    ->schema([
        TextInput::make('title'),
        Textarea::make('content'),
    ])
```

### Vertical Tabs

You can display translations as vertical tabs:

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;

Translations::make('translations')
    ->vertical()
    ->schema([
        TextInput::make('title'),
        Textarea::make('content'),
    ])
```

### Scrollable Tabs

Enable horizontal scroll for tabs when you have many languages:

```php
Translations::make('translations')
    ->scrollable()
    ->locales(['en', 'id', 'fr', 'de', 'es', 'it', 'pt', 'ru', 'zh', 'ja', 'ko', 'ar'])
    ->schema([...])
```

### Clone Locale

The package includes a built-in clone locale feature that allows you to duplicate translations from one locale to another:

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;

Translations::make('translations')
    ->schema([
        TextInput::make('title'),
    ])
```

### Display Flags

Enable flags in locale labels:

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;

Translations::make('translations')
    ->displayFlagsInLocaleLabels(true)
    ->flagWidth('24px')
    ->schema([...])
```

### Using with Astrotomic Mode

```php
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\Forms\Component\Translations;

Translations::make('translations')
    ->translationMode(TranslationMode::Astrotomic)
    ->schema([
        TextInput::make('name'),
    ])
```

### Overriding Plugin Settings per Component

You can override the global plugin settings directly on individual components:

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;

Translations::make()
    ->displayNamesInLocaleLabels(false)
    ->displayFlagsInLocaleLabels(true)
    ->flagWidth('32px')
```

## Full Example

```php
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(
            FilamentTranslatablePlugin::make()
                ->locales(['en', 'id', 'fr', 'de'])
                ->defaultLocale('en')
                ->displayFlagsInLocaleLabels(true)
                ->displayNamesInLocaleLabels(true)
                ->flagWidth('24px')
        );
}

public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('slug'),
        
        Translations::make('translations')
            ->vertical()
            ->displayFlagsInLocaleLabels()
            ->schema([
                TextInput::make('title'),
                RichEditor::make('content'),
            ])
            ->columns(1),
    ]);
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [jegex](https://github.com/jegex)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
