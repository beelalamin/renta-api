<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => User::factory(),
            'booking_id' => Booking::factory(),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
            'method' => $this->faker->randomElement(['credit_card', 'cash_on_delivery']),
            'transaction_id' => $this->faker->unique()->uuid(),
            'recurrent' => $this->faker->boolean(),
        ];
    }
}
