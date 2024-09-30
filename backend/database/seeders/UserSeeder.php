<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU'); // Используем локализацию для русских имен

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->middleName, // Генерация ФИО
                'email' => $faker->unique()->safeEmail, // Уникальный email
                'password' => Hash::make('password'), // Пароль для всех пользователей
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
