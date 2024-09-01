<?php

namespace Database\Factories\Products;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Vehicle;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
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
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
            ],
            'description' => [
                'en' => $this->faker->paragraph,
                'ar' => $this->faker->paragraph,
            ],
            'price' => $this->faker->randomFloat(2, 500, 5000),
            'vehicle_number' => $this->faker->unique()->word,
            'brand_id' => Brand::factory(),
            'thumbnail_id' => Media::factory(),
            'transmission' => $this->faker->randomElement(['manual', 'automatic']),
            'fuel_type' => $this->faker->randomElement(['gasoline', 'hybrid', 'electric']),
            'model' => $this->faker->unique()->word,
            'seating_capacity' => $this->faker->randomElement([2, 4, 5, 6]),
            'mileage' => $this->faker->randomFloat(1, 5, 20),
            'is_featured' => $this->faker->boolean,
            'is_published' => $this->faker->boolean,
            'created_by' => $this->faker->numberBetween(1, 3),
            'updated_by' => $this->faker->numberBetween(1, 3),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Vehicle $vehicle) {
            // Attach categories
            $categories = Category::inRandomOrder()->take(3)->pluck('id');
            $vehicle->categories()->attach($categories);

            // Attach images
            $images = Media::inRandomOrder()->take(3)->pluck('id');
            $vehicle->images()->attach($images);
        });
    }
}
