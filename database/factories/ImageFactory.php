<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $imgName = $this->faker->image(storage_path("app/public/images/images_product"), $width = 640, $height = 480, 'cats', false);
        return [
            'product_id' => Product::all()->random()->id,
            'image' => $imgName,
        ];
    }
}
