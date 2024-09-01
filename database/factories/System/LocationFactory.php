<?php

namespace Database\Factories\System;

use App\Models\System\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'name' => [
                'en' => $this->faker->city(),
                'ar' => $this->faker->city(),
            ],
            'latitude' => [$this->faker->latitude()],
            'langitude' => [$this->faker->longitude()],
        ];
    }
}
