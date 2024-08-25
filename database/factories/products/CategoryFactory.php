<?php

namespace Database\Factories\Products;

use App\Models\Products\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
            'parent_id' => rand(0, 1) ? Category::factory()->create()->id : null,
        ];
    }
}
