<?php

namespace Database\Factories;

use App\Models\ShopifyProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShopifyProductFactory extends Factory
{
    protected $model = ShopifyProduct::class;

    public function definition(): array
    {
        return [
            'id_product' => $this->faker->randomNumber(),
            'id_shopify' => $this->faker->randomNumber(),
            'all' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
