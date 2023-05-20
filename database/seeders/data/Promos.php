<?php


namespace Database\Seeders\data;


class Promos
{
    public static function getData(): array
    {
        $data = [
            [
                'name' => 'Акция на видеокарты Nvidia',
                'slug' => 'akcia-na-videokarty-nvidia',
                'until' => now()->addMonths(5),
                'image' => 'akciya_na_videokarty_nvidia.jpg',
                'description' => fake('ru_RU')->realText(400),
            ],

            [
                'name' => 'Акция на все процессоры AMD Ryzen',
                'slug' => 'akcia-na-vse-processory-amd-ryzen',
                'until' => now()->addMonths(4),
                'image' => 'akciya_na_vse_processory_ryzen.jpg',
                'description' => fake('ru_RU')->realText(400),
            ],

            [
                'name' => 'Акция на процессоры Intel',
                'slug' => 'akcia-na-processory-intel',
                'until' => now()->addMonths(6),
                'image' => 'akciya_na_processory_intel.jpg',
                'description' => fake('ru_RU')->realText(400),
            ],
        ];

        foreach ($data as $promo) {
            $date = now()->subDays(rand(1, 30));
            $promo['created_at'] = $date;
            $promo['updated_at'] = $date;
        }

        return $data;
    }
}
