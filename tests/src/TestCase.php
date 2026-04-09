<?php

namespace Jegex\FilamentTranslatable\Tests;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;
use Livewire\Livewire;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::registerPanel(fn (Panel $panel) => $panel->id('test')
            ->default()
            ->path('')
            ->plugins([
                FilamentTranslatablePlugin::make()
                    ->locales(['en', 'id', 'fr'])
                    ->defaultLocale('en'),
            ]));

        Livewire::setTestNamespace('Jegex\\FilamentTranslatable\\Tests\\Livewire');
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Jegex\FilamentTranslatable\FilamentTranslatableServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
    }
}
