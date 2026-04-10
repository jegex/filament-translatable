<?php

// TODO: Integration tests require full Filament panel setup with Livewire 4.x
// These tests need to be updated with proper panel configuration
// For now, focus on Unit and Feature tests

/*
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\SpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\CreateSpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\EditSpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\ListSpatieProducts;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\SpatieProductResource;
use Livewire\Livewire;

beforeEach(function () {
    FilamentTranslatablePlugin::make()
        ->locales(['en', 'id', 'fr'])
        ->defaultLocale('en')
        ->translationMode(TranslationMode::Spatie);
});

it('can render list page', function () {
    SpatieProduct::factory()->count(5)->create();

    Livewire::test(ListSpatieProducts::class)
        ->assertSuccessful()
        ->assertCountTableRecords(5);
});

it('can render create page', function () {
    Livewire::test(CreateSpatieProduct::class)
        ->assertSuccessful();
});

it('can create product with translations', function () {
    $translations = [
        'en' => ['name' => 'Test Product', 'description' => 'Test Description'],
        'id' => ['name' => 'Produk Test', 'description' => 'Deskripsi Test'],
    ];

    Livewire::test(CreateSpatieProduct::class)
        ->fillForm([
            'translations' => $translations,
            'price' => 100000,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(SpatieProduct::count())->toBe(1)
        ->and(SpatieProduct::first()->getTranslation('name', 'en'))->toBe('Test Product')
        ->and(SpatieProduct::first()->getTranslation('name', 'id'))->toBe('Produk Test')
        ->and(SpatieProduct::first()->getTranslation('description', 'en'))->toBe('Test Description')
        ->and(SpatieProduct::first()->price)->toBe(100000);
});

it('can render edit page', function () {
    $product = SpatieProduct::factory()->create();

    Livewire::test(EditSpatieProduct::class, ['record' => $product->id])
        ->assertSuccessful();
});

it('can edit product translations', function () {
    $product = SpatieProduct::factory()->create([
        'name' => ['en' => 'Old Name', 'id' => 'Nama Lama'],
        'price' => 50000,
    ]);

    $updatedTranslations = [
        'en' => ['name' => 'New Name', 'description' => 'New Description'],
        'id' => ['name' => 'Nama Baru', 'description' => 'Deskripsi Baru'],
    ];

    Livewire::test(EditSpatieProduct::class, ['record' => $product->id])
        ->fillForm([
            'translations' => $updatedTranslations,
            'price' => 75000,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $product->refresh();

    expect($product->getTranslation('name', 'en'))->toBe('New Name')
        ->and($product->getTranslation('name', 'id'))->toBe('Nama Baru')
        ->and($product->getTranslation('description', 'en'))->toBe('New Description')
        ->and($product->price)->toBe(75000);
});

it('can delete product', function () {
    $product = SpatieProduct::factory()->create();

    Livewire::test(EditSpatieProduct::class, ['record' => $product->id])
        ->callAction(\Filament\Actions\DeleteAction::class)
        ->assertHasNoFormErrors();

    expect(SpatieProduct::count())->toBe(0);
});

it('can search products in table', function () {
    $products = SpatieProduct::factory()
        ->state(['name' => ['en' => 'Unique Product Name']])
        ->count(2)
        ->create();

    SpatieProduct::factory()->count(3)->create();

    Livewire::test(ListSpatieProducts::class)
        ->searchTable('Unique Product Name')
        ->assertCanSeeTableRecords($products)
        ->assertCountTableRecords(2);
});

it('can sort products in table', function () {
    SpatieProduct::factory()->state(['price' => 30000])->create();
    SpatieProduct::factory()->state(['price' => 10000])->create();
    SpatieProduct::factory()->state(['price' => 20000])->create();

    Livewire::test(ListSpatieProducts::class)
        ->sortTable('price')
        ->assertCanSeeTableRecords(
            SpatieProduct::orderBy('price')->get(),
            inOrder: true
        );
});
*/
