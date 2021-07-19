<?php

namespace Database\Factories;

use App\Models\Branch;
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
        $imgName = $this->faker->image(storage_path("app/public/images/products"), $width = 640, $height = 480, 'cats', false);
        return [
            'name' => $this->faker->name(),
            'branch_id' => Branch::all()->random()->id,
            'slug' => $this->faker->slug(),
            'short_desc' => $this->faker->text(),
            'desc' => $this->faker->paragraph(),
            'discount' => rand(0, 100),
            'price' => rand(100000, 100000000),
            'competitive_price' => rand(100000, 100000000),
            'image' => $imgName,

        ];
    }
}
