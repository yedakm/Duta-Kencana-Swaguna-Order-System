<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $food = Food::inRandomOrder()->first() ?? Food::factory()->create();
        $quantity = $this->faker->numberBetween(1, 3);
        return [
            'order_id' => Order::factory(),
            'food_id' => $food->id,
            'price' => $food->price,
            'quantity' => $quantity,
        ];
    }
}
