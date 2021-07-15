<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'branch_id' => rand(9, 16),
            'slug' => $this->faker->slug(),
            'short_desc' => $this->faker->text(),
            'desc' => $this->faker->paragraph(),
            'discount' => rand(0, 100),
            'price' => rand(100000, 100000000),
            'competitive_price' => rand(100000, 100000000),
            'image' => 'no image',

        ];
    }
}
