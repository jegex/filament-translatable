<?php

use Jegex\FilamentTranslatable\AstrotomicTranslatableContentDriver;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\AstrotomicProduct;

beforeEach(function () {
    $this->driver = new AstrotomicTranslatableContentDriver('en');
});

it('can detect translatable attribute', function () {
    expect($this->driver->isAttributeTranslatable(AstrotomicProduct::class, 'name'))
        ->toBeTrue();
});

it('can detect non translatable attribute', function () {
    expect($this->driver->isAttributeTranslatable(AstrotomicProduct::class, 'price'))
        ->toBeFalse();
});

it('can make record with fill data', function () {
    $data = [
        'name' => 'Product Name',
        'description' => 'Product Description',
        'price' => 100000,
    ];

    $record = $this->driver->makeRecord(AstrotomicProduct::class, $data);

    expect($record)->toBeInstanceOf(AstrotomicProduct::class);
});

it('can set record locale', function () {
    $product = new AstrotomicProduct;

    $result = $this->driver->setRecordLocale($product);

    expect($result)->toBe($product);
});

it('can update record', function () {
    $product = AstrotomicProduct::create([]);
    $product->translateOrNew('en')->name = 'Old Name';
    $product->translateOrNew('en')->description = 'Old Description';
    $product->save();

    $data = [
        'name' => 'New Name',
        'description' => 'New Description',
    ];

    $updated = $this->driver->updateRecord($product, $data);

    expect($updated->translate('en')->name)->toBe('New Name')
        ->and($updated->translate('en')->description)->toBe('New Description');
});

it('can get record attributes with translations', function () {
    $product = AstrotomicProduct::create([]);
    $product->translateOrNew('en')->name = 'English Name';
    $product->translateOrNew('en')->description = 'English Description';
    $product->translateOrNew('id')->name = 'Nama Indonesia';
    $product->save();

    $attributes = $this->driver->getRecordAttributesToArray($product);

    // Astrotomic driver returns attributes with translations data
    expect($attributes)->toHaveKey('name')
        ->and($attributes['name'])->toBe('English Name');
});
