<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SpatieProduct extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'spatie_products';

    protected $guarded = [];

    public $translatable = ['name', 'description'];
}
