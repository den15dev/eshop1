<?php


namespace Database\Seeders\data;


class Categories
{
    public static function getData(): array
    {
        $data = [
            [
                'name' => 'Компьютерные комплектующие',
                'slug' => 'pc_parts',
                'parent_id' => 0,
                'sort' => 1,
                'image' => 'pc_parts.jpg',
            ],
            [
                'name' => 'Бытовая техника',
                'slug' => 'appliances',
                'parent_id' => 0,
                'sort' => 2,
                'image' => 'appliances.jpg',
            ],
            [
                'name' => 'Телевизоры и аксессуары',
                'slug' => 'tvs_and_accessories',
                'parent_id' => 0,
                'sort' => 3,
                'image' => 'tvs_and_accessories.jpg',
            ],
            [
                'name' => 'Аудиотехника',
                'slug' => 'audio',
                'parent_id' => 0,
                'sort' => 4,
                'image' => 'audio.jpg',
            ],
            [
                'name' => 'Смартфоны и планшеты',
                'slug' => 'smartphones_and_tablets',
                'parent_id' => 0,
                'sort' => 5,
                'image' => 'smartphones_and_tablets.jpg',
            ],


            [
                'name' => 'Процессоры',
                'slug' => 'cpu',
                'parent_id' => 1,
                'sort' => 1,
                'image' => 'cpu.jpg',
            ],
            [
                'name' => 'Материнские платы',
                'slug' => 'motherboards',
                'parent_id' => 1,
                'sort' => 2,
                'image' => 'motherboards.jpg',
            ],
            [
                'name' => 'Видеокарты',
                'slug' => 'gpu',
                'parent_id' => 1,
                'sort' => 3,
                'image' => 'gpu.jpg',
            ],
            [
                'name' => 'Накопители',
                'slug' => 'drives',
                'parent_id' => 1,
                'sort' => 4,
                'image' => 'drives.jpg',
            ],
            [
                'name' => 'Оперативная память',
                'slug' => 'ram',
                'parent_id' => 1,
                'sort' => 5,
                'image' => 'ram.jpg',
            ],
            [
                'name' => 'Блоки питания',
                'slug' => 'psu',
                'parent_id' => 1,
                'sort' => 6,
                'image' => 'psu.jpg',
            ],
            [
                'name' => 'HDD',
                'slug' => 'hdd',
                'parent_id' => 9,
                'sort' => 1,
                'image' => 'hdd.jpg',
            ],
            [
                'name' => 'SSD',
                'slug' => 'ssd',
                'parent_id' => 9,
                'sort' => 2,
                'image' => 'ssd.jpg',
            ],


            [
                'name' => 'Стиральные машины',
                'slug' => 'washing_machines',
                'parent_id' => 2,
                'sort' => 1,
                'image' => 'washing_machines.jpg',
            ],
            [
                'name' => 'Пылесосы',
                'slug' => 'vacuum_cleaners',
                'parent_id' => 2,
                'sort' => 2,
                'image' => 'vacuum_cleaners.jpg',
            ],
            [
                'name' => 'Электрические чайники',
                'slug' => 'electro_kettles',
                'parent_id' => 2,
                'sort' => 3,
                'image' => 'electro_kettles.jpg',
            ],
            [
                'name' => 'Микроволновые печи',
                'slug' => 'microwave_ovens',
                'parent_id' => 2,
                'sort' => 4,
                'image' => 'microwave_ovens.jpg',
            ],
            [
                'name' => 'Кухонные вытяжки',
                'slug' => 'kitchen_hoods',
                'parent_id' => 2,
                'sort' => 5,
                'image' => 'kitchen_hoods.jpg',
            ],


            [
                'name' => 'Телевизоры',
                'slug' => 'tvs',
                'parent_id' => 3,
                'sort' => 1,
                'image' => 'tvs.jpg',
            ],
            [
                'name' => 'Проекторы',
                'slug' => 'projectors',
                'parent_id' => 3,
                'sort' => 2,
                'image' => 'projectors.jpg',
            ],
            [
                'name' => 'Пульты ДУ',
                'slug' => 'remote_controls',
                'parent_id' => 3,
                'sort' => 3,
                'image' => 'remote_controls.jpg',
            ],
            [
                'name' => 'Кабели',
                'slug' => 'connectors',
                'parent_id' => 3,
                'sort' => 4,
                'image' => 'connectors.jpg',
            ],


            [
                'name' => 'Колонки',
                'slug' => 'speakers',
                'parent_id' => 4,
                'sort' => 1,
                'image' => 'speakers.jpg',
            ],
            [
                'name' => 'Наушники',
                'slug' => 'headphones',
                'parent_id' => 4,
                'sort' => 2,
                'image' => 'headphones.jpg',
            ],


            [
                'name' => 'Apple',
                'slug' => 'apple',
                'parent_id' => 5,
                'sort' => 1,
                'image' => 'apple.jpg',
            ],
            [
                'name' => 'Android',
                'slug' => 'android',
                'parent_id' => 5,
                'sort' => 2,
                'image' => 'android.jpg',
            ],


            [
                'name' => 'iPhone',
                'slug' => 'iphone',
                'parent_id' => 25,
                'sort' => 1,
                'image' => 'iphone.jpg',
            ],
            [
                'name' => 'iPad',
                'slug' => 'ipad',
                'parent_id' => 25,
                'sort' => 2,
                'image' => 'ipad.jpg',
            ],
        ];

        foreach ($data as $category) {
            $category['created_at'] = now();
            $category['updated_at'] = now();
        }

        return $data;
    }
}
