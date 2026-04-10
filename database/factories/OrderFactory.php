<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'total_price' => fake()->randomFloat(2, 20, 1000),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'completed', 'cancelled']),
            'shipping_address' => fake()->address(),
            'payment_id' => 'pi_' . fake()->bothify('??##??##??##'),
        ];
    }
}
