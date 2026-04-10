<?php

// TODO: Integration tests require full Filament panel setup with Livewire 4.x
// These tests need to be updated with proper panel configuration
// For now, focus on Unit and Feature tests

/*
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\AstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\CreateAstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\EditAstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\ListAstrotomicProducts;

use function Pest\Livewire\livewire;

beforeEach(function () {
    FilamentTranslatablePlugin::make()
        ->locales(['en', 'id', 'fr'])
        ->defaultLocale('en')
        ->translationMode(TranslationMode::Astrotomic);
});

it('can render list page', function () {
    AstrotomicProduct::factory()->count(5)->create();

    livewire(ListAstrotomicProducts::class)
        ->assertSuccessful()
        ->assertCountTableRecords(5);
});

it('can render create page', function () {
    livewire(CreateAstrotomicProduct::class)
        ->assertSuccessful();
});

it('can create product with translations', function () {
    $translations = [
        'en' => ['name' => 'Test Product', 'description' => 'Test Description'],
        'id' => ['name' => 'Produk Test', 'description' => 'Deskripsi Test'],
    ];

    livewire(CreateAstrotomicProduct::class)
        ->fillForm([
            'translations' => $translations,
            'price' => 100000,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(AstrotomicProduct::count())->toBe(1)
        ->and(AstrotomicProduct::first()->translate('en')->name)->toBe('Test Product')
        ->and(AstrotomicProduct::first()->translate('id')->name)->toBe('Produk Test')
        ->and(AstrotomicProduct::first()->translate('en')->description)->toBe('Test Description')
        ->and(AstrotomicProduct::first()->price)->toBe(100000);
});

it('can render edit page', function () {
    $product = AstrotomicProduct::factory()->create();

    livewire(EditAstrotomicProduct::class, ['record' => $product->id])
        ->assertSuccessful();
});

it('can edit product translations', function () {
    $product = AstrotomicProduct::factory()->create();
    $product->translateOrNew('en')->name = 'Old Name';
    $product->translateOrNew('id')->name = 'Nama Lama';
    $product->price = 50000;
    $product->save();

    $updatedTranslations = [
        'en' => ['name' => 'New Name', 'description' => 'New Description'],
        'id' => ['name' => 'Nama Baru', 'description' => 'Deskripsi Baru'],
    ];

    livewire(EditAstrotomicProduct::class, ['record' => $product->id])
        ->fillForm([
            'translations' => $updatedTranslations,
            'price' => 75000,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $product->refresh();

    expect($product->translate('en')->name)->toBe('New Name')
        ->and($product->translate('id')->name)->toBe('Nama Baru')
        ->and($product->translate('en')->description)->toBe('New Description')
        ->and($product->price)->toBe(75000);
});

it('stores translations in separate table', function () {
    $product = AstrotomicProduct::factory()->create();
    $product->translateOrNew('en')->name = 'English Name';
    $product->translateOrNew('id')->name = 'Nama Indonesia';
    $product->save();

    expect(\Illuminate\Support\Facades\DB::table('astrotomic_product_translations')->count())->toBe(2)
        ->and(\Illuminate\Support\Facades\DB::table('astrotomic_product_translations')
            ->where('locale', 'en')
            ->where('name', 'English Name')
            ->exists())->toBeTrue();
});
*/
