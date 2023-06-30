<?php


namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Product;
use App\Models\Specification;
use App\Services\Site\ImageService;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private function getImagePath(int $product_id): string
    {
        return storage_path('app/public/images/products/' . $product_id);
    }


    public function getImages(int $product_id): array|null
    {
        return Product::select(['id', 'images', 'category_id'])
            ->where('id', $product_id)
            ->first()
            ->images;
    }


    /**
     * Removes images that were removed on product edit page
     *
     * @param int $product_id
     * @param array|null $images_db
     * @param array $images_arr
     */
    public function removeImageFiles(int $product_id, array|null $images_db, array $images_arr): void
    {
        if ($images_db && count($images_db) > count($images_arr)) {
            $product_img_dir = $this->getImagePath($product_id);
            $current_images = array_diff(scandir($product_img_dir), array('..', '.'));

            foreach ($current_images as $old_image) {
                $filename_arr = explode('_', $old_image);
                array_pop($filename_arr);
                $name_base = implode('_', $filename_arr);

                if (!in_array($name_base, $images_arr)) {
                    unlink($product_img_dir . '/' . $old_image);
                }
            }
        }
    }


    /**
     * Checks image's names and find first closest free number ('01', '02', '03', etc.)
     *
     * @param array|null $images_db
     * @return string
     */
    public function getNewImageNameBase(array|null $images_db): string
    {
        $new_name_base = 1;
        if ($images_db) {
            while (in_array(sprintf('%02d', $new_name_base), $images_db)) {
                $new_name_base++;
            }
        }

        return sprintf('%02d', $new_name_base);
    }


    public function saveImage(StoreProductRequest $request, int $product_id, string $name_base): void
    {
        $img_dir = $this->getImagePath($product_id);
        if (!is_dir($img_dir)) {
            mkdir($img_dir);
        }

        $source_path = $request->file('new_image')->path();
        $orig_ext = $request->file('new_image')->getClientOriginalExtension();
        $out_path = $img_dir . '/' . $name_base . '.' . $orig_ext;

        ImageService::saveToSquare($source_path, $out_path, [80, 242, 600], '', false);
    }


    public function getCategorySpecs(int $category_id): ECollection
    {
        return Specification::where('category_id', $category_id)
            ->orderBy('sort')
            ->get();
    }


    public function getProductSpecs(int $product_id): Collection
    {
        return DB::table('product_specification')
            ->where('product_id', $product_id)
            ->get();
    }


    /**
     * Gets specification list for further inserting in a form
     *
     * @param int $category_id
     * @param int $product_id
     * @return string
     */
    public function getProductSpecList(int $category_id, int $product_id): string
    {
        $category_specs = $this->getCategorySpecs($category_id);
        $product_specs = $this->getProductSpecs($product_id);

        foreach ($category_specs as $cat_spec) {
            $prod_spec = $product_specs->first(function ($prod_spec) use ($cat_spec) {
                return $prod_spec->specification_id === $cat_spec->id;
            });

            $cat_spec->spec_value = $prod_spec ? $prod_spec->spec_value : null;
        }

        return $this->buildSpecList($category_specs);
    }


    /**
     * Builds spec list for outputting in a form field.
     *
     * @param $specs
     * @return string
     */
    public function buildSpecList($specs): string
    {
        $out = '';
        foreach ($specs as $spec) {
            $units = $spec->units ? ' <' . $spec->units . '>' : '';
            $is_filter = $spec->is_filter ? '*' : '';
            $value = $spec->spec_value ? ' ' . $spec->spec_value : '';
            $out .= $is_filter . $spec->id . '. ' . $spec->name . $units . ':' . $value . "\n";
        }

        return rtrim($out);
    }


    /**
     * Converts specs from user input to a collection.
     *
     * @param string $specs_input - raw input from a form;
     * @return Collection|null
     */
    public function getInputSpecs(string $specs_input): Collection|null
    {
        $new_specs = [];
        $new_specs_input_arr = explode("\n", $specs_input);
        foreach ($new_specs_input_arr as $new_spec_str) {
            $new_spec = new \stdClass();
            $new_spec->specification_id = ltrim(explode('. ', $new_spec_str)[0], '*');

            $new_spec_value = null;
            $arr1 = explode(':', $new_spec_str);
            if (count($arr1) > 1) {
                $new_spec_value = trim($arr1[count($arr1) - 1]) ?: null;
            }

            if ($new_spec_value) {
                $new_spec->spec_value = $new_spec_value;
                array_push($new_specs, $new_spec);
            }
        }

        return count($new_specs) ? new Collection($new_specs) : null;
    }


    /**
     * Updates product specifications in database.
     *
     * @param int $product_id
     * @param Collection $input_specs - specs came from an user input;
     * @param Collection $current_specs - current product specs.
     */
    public function updateSpecs(int $product_id, Collection $input_specs, Collection $current_specs): void
    {
        $spec_num = $input_specs->count() > $current_specs->count()
            ? $input_specs->count()
            : $current_specs->count();

        for ($i = 0; $i < $spec_num; $i++) {
            if (isset($current_specs[$i]) && isset($input_specs[$i])) {
                DB::table('product_specification')
                    ->where('product_id', $product_id)
                    ->where('specification_id', $current_specs[$i]->specification_id)
                    ->update([
                        'specification_id' => $input_specs[$i]->specification_id,
                        'spec_value' => $input_specs[$i]->spec_value,
                    ]);
            } else if (isset($current_specs[$i]) && !isset($input_specs[$i])) {
                DB::table('product_specification')
                    ->where('product_id', $product_id)
                    ->where('specification_id', $current_specs[$i]->specification_id)
                    ->delete();
            } else if (!isset($current_specs[$i]) && isset($input_specs[$i])) {
                DB::table('product_specification')
                    ->insert([
                        'product_id' => $product_id,
                        'specification_id' => $input_specs[$i]->specification_id,
                        'spec_value' => $input_specs[$i]->spec_value
                    ]);
            }
        }
    }
}
