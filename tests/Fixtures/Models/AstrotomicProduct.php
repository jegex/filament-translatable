<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstrotomicProduct extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $table = 'astrotomic_products';

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];
}
