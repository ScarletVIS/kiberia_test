<?php

namespace Database\Seeders;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Убедимся, что есть товары и пользователи
        if (Product::count() === 0 || User::where('is_admin', false)->count() === 0) {
            $this->command->info('Products and non-admin users are required for orders.');
            return;
        }

        // Создаём 10 заказов для случайных пользователей
        User::where('is_admin', false)->get()->each(function ($user) {
            Order::factory()->create(['user_id' => $user->id]);
        });
    }
}
