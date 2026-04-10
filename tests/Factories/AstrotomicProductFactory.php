<?php

namespace Jegex\FilamentTranslatable\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\AstrotomicProduct;

class AstrotomicProductFactory extends Factory
{
    protected $model = AstrotomicProduct::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }

    public function withTranslations(): static
    {
        return $this->afterCreating(function (AstrotomicProduct $product) {
            foreach (['en', 'id', 'fr'] as $locale) {
                $product->translateOrNew($locale)->name = $this->faker->sentence(3);
                $product->translateOrNew($locale)->description = $this->faker->paragraph();
            }
            $product->save();
        });
    }
}
