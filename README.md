# Filament Translatable (Spatie & Astrotomic)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jegex/filament-translatable.svg?style=flat-square)](https://packagist.org/packages/jegex/filament-translatable)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jegex/filament-translatable/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jegex/filament-translatable/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jegex/filament-translatable/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jegex/filament-translatable/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jegex/filament-translatable.svg?style=flat-square)](https://packagist.org/packages/jegex/filament-translatable)

Filament Translatable adalah paket Laravel untuk Filament yang menambahkan dukungan terjemahan untuk konten panel admin. Paket ini memudahkan Anda menerjemahkan label, teks antarmuka, dan konten dinamis dalam Filament dengan dua pendekatan terkemuka: Spatie Translatable atau Astrotomic/Translatable.

Fitur utama
- Mendukung dua mode terjemahan: Spatie dan Astrotomic (Enum TranslationMode)
- Editor terjemahan berbasis Repeater dengan UI Tabs per locale; tab akan menampilkan bahasa yang tersedia dan bisa ditambahkan melalui tab yang ada
- Definisikan locales secara fleksibel (array/list atau via plugin)
- Label locale dengan bendera (opsional) dan ukuran bendera dapat dikonfigurasi
- Opsi untuk menampilkan nama locale atau hanya kode locales di label
- Kemampuan default locale dan exclusion of certain locales
- Konfigurasi paket melalui publishable config, migrations, dan views
- Integrasi asset Filament (CSS) agar tampilan konsisten

Prerequisites: Pastikan proyek Anda menggunakan Filament v4+, dan Anda sudah menyiapkan package-provider serta mendorong konfigurasi terjemahan pada model Anda (Spatie atau Astrotomic).

## Instalasi

Anda bisa menginstal paket melalui Composer:

```bash
composer require jegex/filament-translatable
```

Jika Anda menggunakan tema khusus Filament Panels, ikuti instruksi styling pada dokumentasi Filament terlebih dahulu.

Menyertakan asset dan publishable resources
- Anda bisa publish migrations, config, dan views jika diperlukan:

```bash
php artisan vendor:publish --tag="filament-translatable-migrations"
php artisan migrate

php artisan vendor:publish --tag="filament-translatable-config"

php artisan vendor:publish --tag="filament-translatable-views"
```

Secara default paket juga mendaftarkan CSS untuk gaya komponen translatable Filament. Sesuaikan dengan cara Anda mengintegrasikan CSS di tema Anda.

## Konfigurasi

Setelah publish, Anda bisa menyesuaikan konfigurasi di config/filament-translatable.php. Contoh konfigurasi minimal:

```php
return [
    // Locales yang didukung, format bisa berupa:
    // ['en' => 'English', 'fr' => 'Français']
    'locales' => [
        'en' => 'English',
        'fr' => 'Français',
        'es' => 'Español',
    ],

    // Locale default
    'default_locale' => 'en',

    // Mode terjemahan: 
    // 
    // Jegex\FilamentTranslatable\Enums\TranslationMode::Spatie
    // atau
    // Jegex\FilamentTranslatable\Enums\TranslationMode::Astrotomic
    'translation_mode' => \Jegex\FilamentTranslatable\Enums\TranslationMode::Spatie,
    
    // Flags/Names di label locale (opsional)
    'display_flags_in_locale_labels' => false,
    'display_names_in_locale_labels' => true,
    'flag_width' => '24px',
];
```

Pastikan Anda menyesuaikan transformasi data di model Anda sesuai dengan package terjemahan yang Anda pakai (Spatie atau Astrotomic).

## Penggunaan (Contoh Filament Form)

- Editor terjemahan menggunakan Repeater dengan UI Tabs per locale. Setiap tab mewakili satu locale yang tersedia, dan Anda bisa menambahkan bahasa baru melalui tab yang ada (Add Locale) pada repeater.

Gunakan komponen Translations dalam schema form Filament Anda untuk memasukkan terjemahan per locale. Contoh:

```php
use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Jegex\FilamentTranslatable\Enums\TranslationMode;

// dalam getForm(Form $form): Form
return $form
    ->schema([
        Translations::make('translations')
            -> locales([
                'en' => 'English',
                'fr' => 'Français',
                'de' => 'Deutsch',
            ])
            -> translationMode(TranslationMode::Astrotomic) // atau TranslationMode::Spatie
            -> defaultLocale('en')
            -> displayFlagsInLocaleLabels(true)
            -> flagWidth('20px'),
    ]);
```

Catatan:
- Jika Anda menggunakan Astrotomic, model Anda harus menggunakan trait Translatable dan mengatur kolom terjemahan seperti biasa (bahkan field sebagai terjemahan per locale).
- Jika Anda menggunakan Spatie, pastikan model Anda menggunakan HasTranslations dan daftar field yang bisa diterjemahkan.

## Pengujian

```bash
composer test
```

## Perubahan & Kontribusi

Lihat CHANGELOG.md untuk perubahan terbaru.
 Kontribusi sangat diterima. Silakan lihat CONTRIBUTING.md untuk panduan.

## Keamanan

Lindungi keamanan proyek dengan merujuk pada POLICY keamanan di .github/SECURITY.md.

## Credits & Lisensi

- jegex (pemilik paket)
- All Contributors

The MIT License (MIT). See LICENSE.md for details.
