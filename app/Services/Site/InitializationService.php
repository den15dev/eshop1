<?php


namespace App\Services\Site;


class InitializationService
{
    /**
     * Checks if the app running for the first time
     */
    public function check(): void
    {
        $this->createImageDir();
    }


    /**
     * If not exists, creates image directory with a structure.
     */
    public function createImageDir(): void
    {
        $img_dir = 'storage/images';
        $img_dir_list = [
            'brands',
            'categories',
            'products',
            'promos',
            'users',
        ];

        if (!(file_exists($img_dir) && is_dir($img_dir))) {
            mkdir($img_dir);
            foreach ($img_dir_list as $dir) {
                mkdir($img_dir . '/' . $dir);
            }
        }
    }
}
