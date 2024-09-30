<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        $products = Product::all();

        // Определяем предыдущие 2 месяца
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Для каждого пользователя сгенерируем 3 продажи
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                // Случайная дата в пределах прошлого месяца
                $soldAt = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate, $endDate)->getTimestamp());

                // Случайный товар
                $product = $products->random();

                // Количество товаров и расчет общей суммы
                $quantity = rand(1, 5);
                $totalPrice = $product->price * $quantity;

                // Создаем запись о продаже
                Sale::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'sale_date' => $soldAt,
                ]);
            }
        }
    }
}
