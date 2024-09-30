<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Определение списка товаров для каждой категории последнего уровня
        $productsByCategory = [
            'Intel' => [
                'Intel Core i9-11900K',
                'Intel Core i7-11700K',
                'Intel Core i5-11600K',
                'Intel Core i3-10100',
                'Intel Pentium Gold G6400'
            ],
            'AMD' => [
                'AMD Ryzen 9 5900X',
                'AMD Ryzen 7 5800X',
                'AMD Ryzen 5 5600X',
                'AMD Ryzen 3 3300X',
                'AMD Athlon 3000G'
            ],
            'ATX' => [
                'ASUS ROG STRIX B550-F Gaming',
                'MSI MPG Z490 Gaming Edge',
                'Gigabyte Z590 AORUS Elite',
                'ASRock B450 Steel Legend',
                'ASUS TUF Gaming X570-Plus'
            ],
            'Micro-ATX' => [
                'Gigabyte B450M DS3H',
                'MSI B450M PRO-VDH MAX',
                'ASUS Prime B365M-A',
                'ASRock B550M-HDV',
                'MSI MAG B460M Mortar'
            ],
            'LCD' => [
                'Samsung 24" CF396 Curved LED Monitor',
                'LG 22MK430H-B 21.5" Full HD IPS Monitor',
                'Acer SB220Q bi 21.5" Full HD Monitor',
                'Dell SE2419Hx 24" Full HD IPS Monitor',
                'HP 24mh FHD Monitor'
            ],
            'LED' => [
                'ASUS VG279Q 27" Full HD Gaming Monitor',
                'BenQ GW2480 24" Full HD IPS Monitor',
                'ViewSonic VX3276-MHD 32" LED Monitor',
                'Philips 276E9QDSB 27" Frameless Monitor',
                'AOC 24G2 24" Frameless Gaming Monitor'
            ],
            'Механические' => [
                'Logitech G Pro X Mechanical Gaming Keyboard',
                'Razer BlackWidow Elite',
                'Corsair K95 RGB Platinum XT',
                'SteelSeries Apex Pro',
                'HyperX Alloy FPS Pro'
            ],
            'Мембранные' => [
                'Logitech K120',
                'Microsoft Ergonomic Keyboard',
                'HP Pavilion Wired Keyboard 300',
                'Dell KB216 Wired Keyboard',
                'Redragon K502 RGB'
            ],
            'Wi-Fi 5' => [
                'TP-Link Archer A7',
                'Netgear Nighthawk R6700',
                'ASUS RT-AC66U B1',
                'Linksys EA7500',
                'D-Link DIR-882'
            ],
            'Wi-Fi 6' => [
                'ASUS RT-AX88U',
                'TP-Link Archer AX50',
                'Netgear Nighthawk AX8',
                'Linksys MX10 Velop Mesh Wi-Fi 6',
                'D-Link DIR-X5460'
            ],
            'Управляемые' => [
                'Netgear GS108E',
                'TP-Link TL-SG108PE',
                'Cisco SG200-08',
                'D-Link DGS-1210-10',
                'Ubiquiti UniFi Switch 8'
            ],
            'Неуправляемые' => [
                'TP-Link TL-SG105',
                'Netgear GS305',
                'D-Link GO-SW-8G',
                'Tenda SG108',
                'Mercusys MS108G'
            ],
        ];

        // Получаем все категории последнего уровня
        $categories = Category::doesntHave('children')->get();

        foreach ($categories as $category) {
            // Проверяем, есть ли список товаров для текущей категории
            if (isset($productsByCategory[$category->name])) {
                $products = $productsByCategory[$category->name];

                foreach ($products as $index => $productName) {
                    // Создаем товар с заданными характеристиками
                    Product::create([
                        'name' => $productName,
                        'price' => rand(500, 50000), // Генерируем случайную цену от 500 до 50 000
                        'category_id' => $category->id,
                        'order' => $index + 1,
                    ]);
                }
            }
        }
    }
}
