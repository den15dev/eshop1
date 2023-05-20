<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name_list1 = [
            'Процессор AMD Ryzen 5 5600X OEM',
            'Процессор AMD Ryzen 5 7600X BOX',
            'Процессор AMD Ryzen 7 5700X',
            'Процессор AMD Ryzen 7 5800X OEM',
            'Процессор AMD Ryzen 9 5900X BOX',
            'Процессор AMD Ryzen 9 5950X BOX',
            'Процессор AMD Ryzen 9 7900X',
            'Процессор AMD Ryzen 9 7950X BOX',
            'Процессор Intel Core i5-12400',
            'Процессор Intel Core i5-13400F OEM',
            'Процессор Intel Core i7-11700KF',
            'Процессор Intel Core i7-12700K BOX',
            'Процессор Intel Core i7-13700KF BOX',
            'Процессор Intel Core i9-13900',
            'Процессор Intel Core i9-12900K',
            'Видеокарта MSI GeForce RTX 4080 SUPRIM X',
            'Видеокарта Palit GeForce RTX 4080 GameRock',
            'Видеокарта GIGABYTE GeForce RTX 4080 GAMING OC',
            'Видеокарта Palit GeForce RTX 4080 GameRock OmniBlack',
            'Видеокарта Palit GeForce RTX 3070 Ti GamingPro',
            'Видеокарта GIGABYTE GeForce RTX 3070 GAMING OC (LHR)',
            'Видеокарта MSI GeForce RTX 3070 VENTUS 3X OC (LHR)',
            'Видеокарта INNO3D GeForce RTX 3070 iCHILL X4 (LHR)',
            'Видеокарта ZOTAC GAMING GeForce RTX 3070 AMP Holo (LHR)',
            'Видеокарта Palit GeForce RTX 4070 Ti GameRock Classic OC',
            'Видеокарта MSI GeForce RTX 4070 Ti GAMING X TRIO',
            'Видеокарта GIGABYTE GeForce RTX 4070 Ti EAGLE OC',
            'Материнская плата GIGABYTE B650 AORUS PRO AX',
            'Материнская плата ASUS ROG STRIX B650-A GAMING WIFI',
            'Материнская плата ASRock X670E Steel Legend',
            'Материнская плата ASUS PRIME X670-P WIFI',
            'Материнская плата GIGABYTE X670 AORUS ELITE AX',
            'Материнская плата ASUS ROG STRIX B650E-F GAMING WIFI',
            'Материнская плата GIGABYTE Z790 AORUS ELITE DDR4',
            'Материнская плата MSI MPG B760I EDGE WIFI DDR4',
            'Материнская плата ASRock Z690 Steel Legend/D5',
            'Материнская плата ASUS ROG STRIX B760-G GAMING WIFI D4',
            'Материнская плата MSI MAG B760M MORTAR MAX WIFI',
        ];


        $short_descr_list1 = [
            'PCI-E 4.0 12 ГБ GDDR6X, 192 бит, DisplayPort x3, HDMI, GPU 2310 МГц',
            'PCI-E 4.0 24 ГБ GDDR6, 384 бит, DisplayPort x3, HDMI, GPU 1900 МГц',
            'PCI-E 3.0 4 ГБ GDDR6, 128 бит, DisplayPort, DVI-D, HDMI, GPU 1410 МГц',
            'LGA 1700, 8P x 3 ГГц, 16E x 2.2 ГГц, L2 - 32 МБ, L3 - 36 МБ, 2хDDR4, DDR5-5600 МГц, TDP 253 Вт',
            'AM4, 8 x 3.4 ГГц, L2 - 4 МБ, L3 - 96 МБ, 2хDDR4-3200 МГц, TDP 105 Вт',
            'LGA 1200, 10 x 3.7 ГГц, L2 - 2.5 МБ, L3 - 20 МБ, 2хDDR4-2933 МГц, TDP 125 Вт',
            'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт',
            'AM5, 12 x 4.7 ГГц, L2 - 12 МБ, L3 - 64 МБ, 2хDDR5-5200 МГц, AMD Radeon Graphics, TDP 170 Вт',
            'LGA 1200, Intel B560, 4xDDR4-3200 МГц, 2xPCI-Ex16, 2xM.2, Micro-ATX',
            'LGA 1700, Intel Z790, 4xDDR4-3200 МГц, 3xPCI-Ex16, 4xM.2, Standard-ATX',
            'AM4, AMD B550, 4xDDR4-3200 МГц, 2xPCI-Ex16, 1xM.2, Standard-ATX',
            'AM5, AMD X670, 2xDDR5-5200 МГц, 1xPCI-Ex16, 2xM.2, Mini-ITX',
            '3 LAN, 1000 Мбит/с, 4 (802.11n), 5 (802.11ac), Wi-Fi 1167 Мбит/с, IPv6',
            '5 LAN, 100 Мбит/с, 4 (802.11n), 5 (802.11ac), Wi-Fi 733 Мбит/с, USB 2.0 x1, 3G, 4G/LTE, IPv6',
            'ядер - 8x(1.7 ГГц, 2.2 ГГц), 8 Гб, 2 SIM, IPS, 2400x1080, камера 108+2 Мп, NFC, 5G, GPS, 5000 мА*ч',
            'ядер - 8x(2.4 ГГц), 8 Гб, 2 SIM, AMOLED, 2400x1080, камера 50+8+2 Мп, NFC, 5G, GPS, 4500 мА*ч',
            '2388x1668, IPS, 8x3.5 ГГц, 8 ГБ, 7538 мА*ч, iPadOS 16',
            '2560x1600, PLS, 8x2.2 ГГц, 6 ГБ, 10090 мА*ч, Android 11.x, стилус',
        ];


        $name_list2 = [
            '4 ТБ Жесткий диск WD Purple',
            '4 ТБ Жесткий диск Seagate SkyHawk',
            '4 ТБ Жесткий диск WD Red IntelliPower',
            '6 ТБ Жесткий диск Toshiba P300',
            '6 ТБ Жесткий диск Seagate BarraCuda',
            '6 ТБ Жесткий диск WD Purple Surveillance',
            '8 ТБ Жесткий диск Seagate BarraCuda',
            '8 ТБ Жесткий диск Toshiba MG08',
        ];


        $short_descr_list2 = [
            'SATA III, 6 Гбит/с, 5400 об/мин, кэш память - 256 МБ, RAID Edition',
            'SATA III, 6 Гбит/с, 5900 об/мин, кэш память - 64 МБ',
            'SATA III, 6 Гбит/с, 5400 об/мин, кэш память - 128 МБ',
            'SATA III, 6 Гбит/с, 5400 об/мин, кэш память - 256 МБ',
            'SATA III, 6 Гбит/с, 5400 об/мин, кэш память - 64 МБ, RAID Edition',
            'SATA III, 6 Гбит/с, 7200 об/мин, кэш память - 256 МБ',
        ];


        $name = $name_list2[array_rand($name_list2)];
        $slug = str($name)->slug();

//        $lastCategories = CategoryService::getChildFree();
//        $category_id = $lastCategories[array_rand($lastCategories)];

//        $categories = array(6, 7);
//        $category_id = $categories[array_rand($categories)];

//        $category_id = Category::where('slug', 'cpu')->first()->id; // CPUs
        $category_id = Category::where('slug', 'hdd')->first()->id; // HDD

        $short_descr = $short_descr_list2[array_rand($short_descr_list2)];

        $price = fake()->numberBetween(4, 700) * 100 - 10;
        $price = number_format($price, 2, '.', '');
        $discount_prc = fake()->randomElement([0, 0, 0, 0, 0, 0, 5, 10]);
        $final_price = $price;
        if ($discount_prc > 0) {
            $final_price = bcmul($price, bcdiv(bcsub(100, $discount_prc), 100));
        }

        $date_time = fake()->dateTimeBetween('-3 month');

        return [
            'name' => $name,
            'slug' => $slug,
            'category_id' => $category_id,
            'sku' => fake()->isbn10(),
            'brand_id' => Brand::all('id')->random()->id,
            'short_descr' => $short_descr,
            'price' => $price,
            'discount_prc' => $discount_prc,
            'final_price' => $final_price,
            'rating' => fake()->randomFloat(2, 1, 5),
            'vote_num' => fake()->numberBetween(1, 265),
            'images' => array('01', '02', '03', '04'),
            'description' => fake('ru_RU')->realText(700),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}
