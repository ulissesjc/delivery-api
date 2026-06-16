<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 10),
            'unit_price' => fake()->randomFloat(2, 5, 100),
            'subtotal' => fn (array $attrs) => $attrs['unit_price'] * $attrs['quantity'],
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (OrderItem $item) {
            $item->product_name = $item->product->name;
        });
    }
}
