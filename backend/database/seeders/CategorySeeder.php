<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Уровень 1 - основные категории
        $categoriesLevel1 = [
            'Комплектующие',
            'Периферия',
            'Сетевые устройства',
        ];

        // Уровень 2 - подкатегории для каждого из уровней 1
        $categoriesLevel2 = [
            'Комплектующие' => ['Процессоры', 'Материнские платы'],
            'Периферия' => ['Мониторы', 'Клавиатуры'],
            'Сетевые устройства' => ['Роутеры', 'Свитчи'],
        ];

        // Уровень 3 - подкатегории для каждого из уровней 2
        $categoriesLevel3 = [
            'Процессоры' => ['Intel', 'AMD'],
            'Материнские платы' => ['ATX', 'Micro-ATX'],
            'Мониторы' => ['LCD', 'LED'],
            'Клавиатуры' => ['Механические', 'Мембранные'],
            'Роутеры' => ['Wi-Fi 5', 'Wi-Fi 6'],
            'Свитчи' => ['Управляемые', 'Неуправляемые'],
        ];

        // Создание категорий 1-го уровня
        foreach ($categoriesLevel1 as $index1 => $category1) {
            $parentCategory1 = Category::create([
                'name' => $category1,
                'parent_id' => null,
                'order' => $index1 + 1,
            ]);

            // Создание категорий 2-го уровня
            if (isset($categoriesLevel2[$category1])) {
                foreach ($categoriesLevel2[$category1] as $index2 => $category2) {
                    $parentCategory2 = Category::create([
                        'name' => $category2,
                        'parent_id' => $parentCategory1->id,
                        'order' => $index2 + 1,
                    ]);

                    // Создание категорий 3-го уровня
                    if (isset($categoriesLevel3[$category2])) {
                        foreach ($categoriesLevel3[$category2] as $index3 => $category3) {
                            Category::create([
                                'name' => $category3,
                                'parent_id' => $parentCategory2->id,
                                'order' => $index3 + 1,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
