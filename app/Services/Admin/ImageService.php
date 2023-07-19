<?php


namespace App\Services\Admin;

use Intervention\Image\Facades\Image;

class ImageService
{
    private array $extensions = ['jpg', 'jpeg', 'png', 'svg'];

    private const IMG_DIR = 'storage/images';


    public function saveImageBySlug(string $directory, $image_file, string $slug): void
    {
        $base_path = self::IMG_DIR . '/' . $directory . '/' . $slug;

        $this->deleteImageBySlug($directory, $slug);

        $source_path = $image_file->path();
        $extension = $image_file->extension();
        $out_path = $base_path . '.' . $extension;

        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $image = Image::make($source_path);
            $image->save($out_path, 85);
        } else {
            $extension = pathinfo($image_file->getClientOriginalName(), PATHINFO_EXTENSION);
            $new_filename = $slug . '.' . $extension;
            $image_file->storeAs('images/' . $directory, $new_filename);
        }
    }


    public function deleteImageBySlug(string $directory, string $slug): void
    {
        $base_path = self::IMG_DIR . '/' . $directory . '/' . $slug;

        foreach ($this->extensions as $ext) {
            $img_path = $base_path . '.' . $ext;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }
    }


    public function renameImageBySlug(string $directory, string $slug_new, string $slug_old): void
    {
        if ($slug_new !== $slug_old) {
            $base_path = self::IMG_DIR . '/' . $directory . '/' . $slug_old;

            foreach ($this->extensions as $ext) {
                $old_name = $base_path . '.' . $ext;
                if (file_exists($old_name)) {
                    $new_name = self::IMG_DIR . '/' . $directory . '/' . $slug_new . '.' . $ext;
                    rename($old_name, $new_name);
                }
            }
        }
    }


    public function deleteImageByName(string $directory, int $id, string $name): void
    {
        $img_path = self::IMG_DIR . '/' . $directory . '/' . $id . '/' . $name;

        if (file_exists($img_path)) {
            unlink($img_path);
            rmdir(self::IMG_DIR . '/' . $directory . '/' . $id);
        }
    }
}
