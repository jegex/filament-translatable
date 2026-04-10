<?php

namespace Jegex\FilamentTranslatable\Tests;

use Filament\FilamentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jegex\FilamentTranslatable\FilamentTranslatableServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Translatable\TranslatableServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Jegex\\FilamentTranslatable\\Tests\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            TranslatableServiceProvider::class,
            FilamentTranslatableServiceProvider::class,
        ];
    }

    protected function setUpDatabase(): void
    {
        // Create Spatie Products table
        Schema::create('spatie_products', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });

        // Create Astrotomic Products table
        Schema::create('astrotomic_products', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });

        // Create Astrotomic Product Translations table
        Schema::create('astrotomic_product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('astrotomic_product_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unique(['astrotomic_product_id', 'locale']);
        });

        // Create users table for authentication
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('filament-translatable', [
            'locales' => ['en', 'id', 'fr'],
            'default_locale' => 'en',
            'translation_mode' => 'spatie',
        ]);

        // Setup Astrotomic locales configuration
        config()->set('translatable.locales', [
            'en',
            'id',
            'fr',
        ]);
    }
}
