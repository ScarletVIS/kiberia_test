<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создать 1 администратора
        User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'balance' => 0,
            'is_admin' => true,
        ]);

        // Создать 10 обычных пользователей
        User::factory()->count(10)->create();


    }
}
