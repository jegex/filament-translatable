<?php

use Jegex\FilamentTranslatable\SpatieTranslatableContentDriver;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\SpatieProduct;

beforeEach(function () {
    $this->driver = new SpatieTranslatableContentDriver('en');
});

it('can detect translatable attribute', function () {
    expect($this->driver->isAttributeTranslatable(SpatieProduct::class, 'name'))
        ->toBeTrue();
});

it('can detect non translatable attribute', function () {
    expect($this->driver->isAttributeTranslatable(SpatieProduct::class, 'price'))
        ->toBeFalse();
});

it('can detect non existing attribute', function () {
    expect($this->driver->isAttributeTranslatable(SpatieProduct::class, 'invalid_attribute'))
        ->toBeFalse();
});

it('can make record with translations', function () {
    $data = [
        'name' => 'Product Name',
        'description' => 'Product Description',
        'price' => 100000,
    ];

    $record = $this->driver->makeRecord(SpatieProduct::class, $data);

    expect($record)->toBeInstanceOf(SpatieProduct::class)
        ->and($record->getTranslation('name', 'en'))->toBe('Product Name')
        ->and($record->getTranslation('description', 'en'))->toBe('Product Description')
        ->and($record->price)->toBe(100000);
});

it('does not change locale on setRecordLocale', function () {
    $product = new SpatieProduct;

    $result = $this->driver->setRecordLocale($product);

    expect($result)->toBe($product);
});

it('can update record with translations', function () {
    $product = SpatieProduct::create([
        'name' => ['en' => 'Old Name'],
        'description' => ['en' => 'Old Description'],
        'price' => 50000,
    ]);

    $data = [
        'name' => 'New Name',
        'description' => 'New Description',
    ];

    $updated = $this->driver->updateRecord($product, $data);

    expect($updated->getTranslation('name', 'en'))->toBe('New Name')
        ->and($updated->getTranslation('description', 'en'))->toBe('New Description')
        ->and($updated->fresh()->getTranslation('name', 'en'))->toBe('New Name');
});

it('can get record attributes for active locale', function () {
    $product = SpatieProduct::create([
        'name' => ['en' => 'English Name', 'id' => 'Nama Indonesia'],
        'description' => ['en' => 'English Description', 'id' => 'Deskripsi Indonesia'],
        'price' => 75000,
    ]);

    $driver = new SpatieTranslatableContentDriver('id');

    $attributes = $driver->getRecordAttributesToArray($product);

    expect($attributes['name'])->toBe('Nama Indonesia')
        ->and($attributes['description'])->toBe('Deskripsi Indonesia')
        ->and($attributes['price'])->toBe(75000);
});

it('can get all translations for all locales', function () {
    $product = SpatieProduct::create([
        'name' => ['en' => 'English', 'id' => 'Indonesia', 'fr' => 'Français'],
        'description' => ['en' => 'English Desc', 'id' => 'Deskripsi'],
    ]);

    $translations = $this->driver->getAllTranslationsForAllLocales($product);

    expect($translations['name'])->toHaveKeys(['en', 'id', 'fr'])
        ->and($translations['name']['en'])->toBe('English')
        ->and($translations['name']['id'])->toBe('Indonesia')
        ->and($translations['name']['fr'])->toBe('Français')
        ->and($translations['description']['en'])->toBe('English Desc')
        ->and($translations['description']['id'])->toBe('Deskripsi');
});

it('returns empty translations for unsaved model', function () {
    $product = new SpatieProduct;

    $translations = $this->driver->getAllTranslationsForAllLocales($product);

    // Unsaved model will have empty translatable attributes registered
    expect($translations)->toHaveKey('name')
        ->and($translations['name'])->toBe([]);
});

it('can handle indonesian locale', function () {
    $driver = new SpatieTranslatableContentDriver('id');

    $data = [
        'name' => 'Nama Produk',
        'description' => 'Deskripsi Produk',
    ];

    $record = $driver->makeRecord(SpatieProduct::class, $data);

    expect($record->getTranslation('name', 'id'))->toBe('Nama Produk')
        ->and($record->getTranslation('description', 'id'))->toBe('Deskripsi Produk');
});
