<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages;

use Filament\Resources\Pages\ListRecords;
use Jegex\FilamentTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\SpatieProductResource;

class ListSpatieProducts extends ListRecords
{
    use Translatable;

    protected static string $resource = SpatieProductResource::class;
}
