<?php

namespace Jegex\FilamentTranslatable\Tests\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class AstrotomicPost extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'astrotomic_posts';

    protected $fillable = ['author'];

    public array $translatedAttributes = ['title', 'content'];
}
