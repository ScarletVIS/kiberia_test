<?php

namespace Database\Factories;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
            'user_id' => User::factory(),
            'total' => fake()->randomFloat(2, 10, 500),
            'status' => 'new',
            'ordered_at' => fake()->dateTime,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->take(rand(1, 5))->get();
            $total = 0;

            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $price = $product->price; // Текущая цена продукта
                $total += $price * $quantity;

                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price, // Сохраняем цену на момент покупки
                ]);
            }

            $order->update(['total' => $total]);
        });
    }
}
