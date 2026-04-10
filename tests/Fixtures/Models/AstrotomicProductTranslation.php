<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstrotomicProductTranslation extends Model
{
    use HasFactory;

    protected $table = 'astrotomic_product_translations';

    public $timestamps = false;

    protected $guarded = [];

    public $incrementing = false;

    protected $fillable = ['name', 'description'];
}
