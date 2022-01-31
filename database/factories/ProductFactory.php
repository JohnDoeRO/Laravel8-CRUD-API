<?php

namespace Database\Factories;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->unique()->word,
            'product_desc' => $this->faker->paragraph,
            'product_category' => $this->faker->unique()->word,
            'product_price' =>  $this->faker->randomFloat(2, 0, 10000),
        ];
    }
}
