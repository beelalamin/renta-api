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
            'price' => $this->faker->optional()->randomFloat(2, 1000, 50000),
            'vehicle_number' => $this->faker->unique()->word,
            'brand_id' => Brand::factory(),
            'thumbnail_id' => Media::factory(), // If you are using media, otherwise, you can remove this line
            'status' => $this->faker->boolean,
            'transmission' => $this->faker->randomElement(['manual', 'automatic']),
            'attributes' => [
                'color' => $this->faker->colorName,
                'size' => $this->faker->word,
            ],
            'booking_type' => $this->faker->randomElement(['rental', 'subscription', 'both']),
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
