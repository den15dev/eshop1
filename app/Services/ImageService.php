<?php


namespace App\Services;

use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * Fits source image to square preserving its aspect ratio and saves a result.
     *
     * @param string $source_path - source image path.
     * @param string $out_path - output (destination) image path.
     * @param int|array $sizes - size, or array of sizes, e.g. [600, 242, 80].
     * @param bool|string $suffix - the string that will be used for file name suffix;
     *                              by default (empty string) - a resolution number will be used;
     *                              if false, no suffix will be applied;
     * @param bool $crop - if true, a smallest side will be fitted, a biggest side will be cropped,
     *                     if false, a biggest side will be fitted, gaps will be filled with white.
     * @param int $quality - converting quality, maximum 100.
     */
    public static function saveToSquare(
        string $source_path,
        string $out_path,
        int|array $sizes,
        bool|string $suffix = '',
        bool $crop = true,
        int $quality = 85
    ): void
    {
        if ($quality > 100) $quality = 100;

        //Prepare output file name for resolution suffix
        $path_arr = explode('.', $out_path);
        $basepath = $path_arr[count($path_arr) - 2];

        if (!is_array($sizes)) {
            $sizes = array($sizes);
        }

        foreach ($sizes as $size) {
            // Add resolution suffix
            if ($suffix !== false) {
                $path_arr[count($path_arr) - 2] = $suffix === '' ? $basepath.'_'.$size : $basepath.'_'.$suffix;
            }

            $out_path = implode('.', $path_arr);

            $image = Image::make($source_path);

            if ($crop) {
                $image->fit($size, $size);
            } else {
                $source = $image->resize($size, $size, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image = Image::canvas($size, $size, '#ffffff')->insert($source, 'center');
            }

            $image->save($out_path, $quality);
        }
    }



    /**
     * Seeds the folder with square images of arbitrary sizes.
     *
     * Every image with all its size variations will be placed in a separate folder.
     * Names of the folders will be numeric starting from 1.
     *
     * @param string $source_dir
     * @param string $out_dir
     * @param int|array $sizes - size, or array of sizes, e.g. [600, 242, 80].
     *
     * @return int|bool - number of successfully handled images, or false if source directory was not found
     */
    public static function seedProductFolder(string $source_dir, string $out_dir, int|array $sizes): int|bool
    {
        $result = 0; // Number of successfully handled images

        if (file_exists($source_dir)) {
            $src_dir_arr = array_diff(scandir($source_dir), array('..', '.'));

            $id = 1;
            foreach ($src_dir_arr as $img_dir) {
                if (is_dir($source_dir . '/' . $img_dir)) {

                    $image_arr = array_diff(scandir($source_dir . '/' . $img_dir), array('..', '.'));

                    if (count($image_arr) > 0) {

                        mkdir($out_dir . '/' . $id);

                        $img_num = 1;
                        foreach ($image_arr as $img_filename) {

                            // Pad-left with zero if lower than 10
                            $img_num_str = sprintf('%02d', $img_num);

                            $source_img = $source_dir . '/' . $img_dir . '/' . $img_filename;

                            $ext = '.' . pathinfo($source_img, PATHINFO_EXTENSION);
                            $out_img = $out_dir . '/' . $id . '/' . $img_num_str . $ext;

                            self::saveToSquare($source_img, $out_img, $sizes, false);

                            $img_num++;
                            $result++;
                        }

                        $id++;
                    }
                }
            }

        } else {
            return false;
        }

        return $result;
    }
}
