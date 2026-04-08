<?php

namespace Jegex\FilamentTranslatable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jegex\FilamentTranslatable\FilamentTranslatable
 */
class FilamentTranslatable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Jegex\FilamentTranslatable\FilamentTranslatable::class;
    }
}
