<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
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
    public function definition(): array
    {
        // static $index = 0;
        // $index += 1;
        return [
            'name' => fake()->words(3,true). ' '.fake()->randomElement(['Shirt', 'Shoes', 'Hat', 'Bag']),
            'description' =>fake()->realText(300),
            'price' =>fake()->randomFloat(2,10,1000),
            'vendor' => 'FPInfo',
            'product_type' =>fake()->randomElement(['dog','cat','bird']),
            'status' =>fake()->randomElement(['active','archived','draft']),
            'quantity' =>fake()->randomNumber(1,3),
            'image' =>fake()->unique()->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


}
