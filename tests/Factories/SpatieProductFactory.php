<?php

namespace Jegex\FilamentTranslatable\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\SpatieProduct;

class SpatieProductFactory extends Factory
{
    protected $model = SpatieProduct::class;

    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->sentence(3),
                'id' => $this->faker->sentence(3),
                'fr' => $this->faker->sentence(3),
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'id' => $this->faker->paragraph(),
                'fr' => $this->faker->paragraph(),
            ],
            'price' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }

    public function withoutTranslations(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'description' => null,
        ]);
    }
}
