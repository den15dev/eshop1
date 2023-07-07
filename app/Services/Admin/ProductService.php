<?php


namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Product;
use App\Services\Site\ImageService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static array $table_settings = [
        [
            'column' => 'id',
            'title' => 'id',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'images',
            'title' => '',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'name',
            'title' => 'Наименование',
            'align' => 'start',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'is_active',
            'title' => 'Активно',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'discount_prc',
            'title' => 'Скидка %',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'final_price',
            'title' => 'Цена, ₽',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];


    public function saveProduct(StoreProductRequest $request): Product
    {
        $product = new Product();
        $validated = $request->validated();

        $product->name = $validated['name'];
        $product->slug = str($validated['name'])->slug();
        $product->category_id = $validated['category_id'];
        $product->sku = $validated['sku'];
        $product->brand_id = $validated['brand_id'];
        $product->short_descr = $validated['short_descr'];
        $product->price = $validated['price'];
        $product->discount_prc = $validated['discount_prc'];
        $product->final_price = $validated['final_price'];
        $product->description = $validated['description'];
        $product->is_active = $validated['is_active'];
        $product->promo_id = $validated['promo_id'] ?: null;

        $images_arr = [];
        foreach ($request->file('image_files') as $key => $file) {
             $images_arr[] = sprintf('%02d', ($key + 1));
        }
        $product->images = count($images_arr) ? $images_arr : null;

        $product->save();

        return $product;
    }


    public function saveImages(StoreProductRequest $request, int $product_id)
    {
        foreach ($request->file('image_files') as $key => $file) {
            $this->saveImage($file, $product_id, sprintf('%02d', ($key + 1)));
        }
    }


    public function updateImages(StoreProductRequest $request, int $product_id)
    {
        $images_json = $request->input('images') ?: null;
        $images_arr = $images_json ? json_decode($images_json) : [];
        $images_db = $this->getImages($product_id);

        $this->updateImageFiles($product_id, $images_db, $images_arr);

        if ($request->hasFile('new_image')) {
            $new_name_base = $this->getNewImageNameBase($images_db);
            $file = $request->file('new_image');
            $this->saveImage($file, $product_id, $new_name_base);

            array_push($images_arr, $new_name_base);
            $images_json = json_encode($images_arr);
        }

        if (json_encode($images_db) !== $images_json) {
            Product::where('id', $product_id)->update(['images' => $images_json]);
        }
    }


    public function deleteImages(int $product_id)
    {
        $img_dir = $this->getImagePath($product_id);
        if (is_dir($img_dir)) {
            $images = array_diff(scandir($img_dir), array('..', '.'));
            foreach ($images as $image) {
                unlink($img_dir . '/' . $image);
            }

            rmdir($img_dir);
        }
    }


    public function saveSpecifications(string $raw_specs_input, int $category_id, int $product_id)
    {
        $input_specs = $this->getInputSpecs($raw_specs_input);
        $input_specs = $this->filterInputSpecs($input_specs, $category_id);
        $current_specs = $this->getProductSpecs($product_id);

        $this->updateSpecs($product_id, $input_specs, $current_specs);
    }


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
    public function updateImageFiles(int $product_id, array|null $images_db, array $images_arr): void
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


    public function saveImage($file, int $product_id, string $name_base): void
    {
        $img_dir = $this->getImagePath($product_id);
        if (!is_dir($img_dir)) {
            mkdir($img_dir);
        }

        $source_path = $file->path();
        $orig_ext = $file->getClientOriginalExtension();
        $out_path = $img_dir . '/' . $name_base . '.' . $orig_ext;

        ImageService::saveToSquare($source_path, $out_path, [80, 242, 600, 1400], '', false);
    }


    public function getProductSpecs(int $product_id): Collection
    {
        return DB::table('product_specification')
            ->where('product_id', $product_id)
            ->get();
    }


    /**
     * Gets specification list for further inserting in a form.
     * If a product id given, gets a corresponding spec value.
     *
     * @param int $category_id
     * @param int|null $product_id
     * @return string
     */
    public function getProductSpecList(int $category_id, int|null $product_id = null): string
    {
        $category_specs = CategoryService::getCategorySpecs($category_id);

        if ($product_id) {
            $product_specs = $this->getProductSpecs($product_id);
            foreach ($category_specs as $cat_spec) {
                $prod_spec = $product_specs->first(function ($prod_spec) use ($cat_spec) {
                    return $prod_spec->specification_id === $cat_spec->id;
                });

                $cat_spec->spec_value = $prod_spec ? $prod_spec->spec_value : null;
            }
        } else {
            foreach ($category_specs as $cat_spec) {
                $cat_spec->spec_value = null;
            }
        }

        return $this->buildSpecList($category_specs);
    }


    /**
     * Builds spec list for outputting in a form field.
     *
     * @param Collection $specs
     * @return string
     */
    public function buildSpecList(Collection $specs): string
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
     * Converts product specs from user input to a collection.
     *
     * @param string $specs_input - raw input from a form;
     * @return Collection
     */
    public function getInputSpecs(string $specs_input): Collection
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

        return new Collection($new_specs);
    }


    /**
     * Checks if given input specification exists in the category. If not, remove it.
     *
     * @param Collection $input_specs
     * @param int $category_id
     * @return Collection
     */
    public function filterInputSpecs(Collection $input_specs, int $category_id): Collection
    {
        $category_specs = CategoryService::getCategorySpecs($category_id);

        return $input_specs->filter(function ($input_spec) use ($category_specs) {
            return $category_specs->contains('id', $input_spec->specification_id);
        });
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

        DB::transaction(function () use (
            $spec_num,
            $product_id,
            $current_specs,
            $input_specs
        ) {
            for ($i = 0; $i < $spec_num; $i++) {
                if (isset($current_specs[$i]) && isset($input_specs[$i])) {
                    DB::table('product_specification')
                        ->where('id', $current_specs[$i]->id)
                        ->update([
                            'specification_id' => $input_specs[$i]->specification_id,
                            'spec_value' => $input_specs[$i]->spec_value,
                        ]);
                } else if (isset($current_specs[$i]) && !isset($input_specs[$i])) {
                    DB::table('product_specification')
                        ->where('id', $current_specs[$i]->id)
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
        }, 3);
    }


    public function updateCategoryId(int $product_id, int $category_id): void
    {
        Product::where('id', $product_id)->update(['category_id' => $category_id]);
    }
}
