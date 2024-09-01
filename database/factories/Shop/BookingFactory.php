<?php

namespace Database\Factories\Shop;

use App\Models\Products\Vehicle;
use App\Models\Shop\Booking;
use App\Models\System\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'protection' => $this->faker->randomElement(['basic', 'partial', 'full']),
            'booking_type' => $this->faker->randomElement(['rental', 'subscription']),
            'status' => $this->faker->randomElement(['new', 'processing', 'completed', 'cancelled']),
            'mileage' => $this->faker->numberBetween(1000, 10000),
            'booking_number' => $this->faker->unique()->numerify('BN-#####'),
            'infant_seat' => $this->faker->randomElement([null, 1, 2]),
            'driver' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->paragraph(),
            'pickup_location_id' => Location::factory(),
            'return_location_id' => Location::factory(),
            'pickup_date' => now(),
            // 'pickup_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'return_date' => now(),
            // 'return_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'subscription_plan' => $this->faker->optional()->randomElement(['basic', 'premium']),
            'billing_cycle' => $this->faker->optional()->randomElement(['weekly', 'monthly']),
            'auto_renewal' => $this->faker->boolean(),
            'last_notified' => now(),
            // 'last_notified' => $this->faker->optional()->dateTimeThisYear(),
            'renewal_date' => now(),
            // 'renewal_date' => $this->faker->optional()->dateTimeThisYear()->format('Y-m-d'),
            'next_billing_date' => now(),
            // 'next_billing_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),

        ];
    }
}
