<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_name' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
            'model_name' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
        ];
    }
}
