<?php


namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;

class CategoryService
{
    public function saveCategory(StoreCategoryRequest $request): Category
    {
        $validated = $request->validated();

        $this->updateSortWhenInserting($validated['parent_id'], $validated['sort']);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->parent_id = $validated['parent_id'];
        $category->sort = $validated['sort'];
        $category->save();

        return $category;
    }


    public function saveSpecifications(StoreCategoryRequest $request, int $category_id): void
    {
        $validated = $request->validated();

        if ($validated['specs']) {
            $input_specs = $this->getInputSpecs($validated['specs']);
            foreach ($input_specs as $spec) {
                $new_spec = new Specification();
                $new_spec->category_id = $category_id;
                $new_spec->name = $spec->name;
                $new_spec->units = $spec->units;
                $new_spec->sort = $spec->sort;
                $new_spec->is_filter = $spec->is_filter;
                $new_spec->save();
            }
        }
    }


    public static function getCategorySpecs(int $category_id): ECollection
    {
        return Specification::where('category_id', $category_id)
            ->orderBy('sort')
            ->get();
    }


    /**
     * Gets category specification list for further inserting in a form.
     *
     * @param int $category_id
     * @return string
     */
    public function getCategorySpecList(int $category_id): string
    {
        $category_specs = self::getCategorySpecs($category_id);

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
            $out .= $is_filter . $spec->id . '. ' . $spec->name . $units . "\n";
        }

        return rtrim($out);
    }


    /**
     * Gets categories which doesn't have any children category.
     *
     * @return Collection|null
     */
    public function getEndCategories(): Collection|null
    {
        $categories = Category::orderBy('name')->get();
        $end_categories = [];

        foreach ($categories as $category) {
            $has_children = false;
            foreach ($categories as $child) {
                if ($category->id === $child->parent_id) {
                    $has_children = true;
                }
            }
            if (!$has_children) {
                array_push($end_categories, $category);
            }
        }

        return count($end_categories) ? new Collection($end_categories) : null;
    }


    /**
     * Gets number of children categories for given parent category
     *
     * @param int|null $parent_id
     * @return int
     */
    public function getChildrenNum(int|null $parent_id): int
    {
        $parent_id = $parent_id ?? 0;

        return Category::where('parent_id', $parent_id)->count();
    }


    public function updateSortOrder(StoreCategoryRequest $request): void
    {
        $validated = $request->validated();
        $parent_id_new = $validated['parent_id'];
        $parent_id_old = $request->input('parent_id_old');
        $sort_new = $validated['sort'];
        $sort_old = $request->input('sort_old');

        if ($parent_id_new === $parent_id_old) {
            if ($sort_new > $sort_old) {
                Category::where('parent_id', $parent_id_old)
                    ->where('sort', '>', $sort_old)
                    ->where('sort', '<=', $sort_new)
                    ->decrement('sort');
            } elseif ($sort_new < $sort_old) {
                Category::where('parent_id', $parent_id_old)
                    ->where('sort', '<', $sort_old)
                    ->where('sort', '>=', $sort_new)
                    ->increment('sort');
            }
        } else {
            $this->updateSortWhenInserting($parent_id_new, $sort_new);
            $this->updateSortWhenDeleting($parent_id_old, $sort_old);
        }
    }


    public function updateSortWhenInserting(int $parent_id, int $sort): void
    {
        Category::where('parent_id', $parent_id)
            ->where('sort', '>=', $sort)
            ->increment('sort');
    }


    public function updateSortWhenDeleting(int $parent_id, int $sort): void
    {
        Category::where('parent_id', $parent_id)
            ->where('sort', '>', $sort)
            ->decrement('sort');
    }


    /**
     * Converts category specs from user input to a collection.
     *
     * @param string $raw_specs_input
     * @return Collection
     */
    public function getInputSpecs(string $raw_specs_input): Collection
    {
        $new_specs = [];

        $sort = 1;
        $raw_specs_arr = explode("\n", $raw_specs_input);
        foreach ($raw_specs_arr as $spec_line) {
            $spec_line = trim($spec_line);
            $spec = new \stdClass();

            // Look for an asterisk
            $spec->is_filter = mb_substr($spec_line, 0, 1) === '*' ? 1 : 0;
            $spec_line = trim($spec_line, '* ');

            // Parse specification id
            if (preg_match('/^(\d+)\.\s?(.+)/', $spec_line, $matches)) {
                $spec->id = intval($matches[1]);
                $spec_line = trim($matches[2]);
            } else {
                $spec->id = null;
            }

            // Parse units
            if (preg_match('/(.+)<(.+)>$/', $spec_line, $matches)) {
                $spec->name = rtrim($matches[1]);
                $spec->units = trim($matches[2]);
            } else {
                $spec->name = $spec_line;
                $spec->units = null;
            }

            $spec->sort = $sort;

            array_push($new_specs, $spec);
            $sort++;
        }

        return new Collection($new_specs);
    }


    public function updateSpecs(Collection $input_specs, int $category_id): void
    {
        $current_specs = self::getCategorySpecs($category_id);

        foreach ($input_specs as $input_spec) {
            if ($input_spec->id) {
                $cur_spec = $current_specs->firstWhere('id', $input_spec->id);
                if ($cur_spec) {
                    // Updating current spec
                    Specification::where('id', $cur_spec->id)
                        ->update([
                            'name' => $input_spec->name,
                            'units' => $input_spec->units,
                            'sort' => $input_spec->sort,
                            'is_filter' => $input_spec->is_filter,
                        ]);

                    continue;
                }
            }

            // Inserting new spec
            $new_spec = new Specification();
            $new_spec->category_id = $category_id;
            $new_spec->name = $input_spec->name;
            $new_spec->units = $input_spec->units;
            $new_spec->sort = $input_spec->sort;
            $new_spec->is_filter = $input_spec->is_filter;
            $new_spec->save();
        }

        // Deleting unneeded specs
        foreach ($current_specs as $cur_spec) {
            $input_spec = $input_specs->firstWhere('id', $cur_spec->id);
            if (!$input_spec) {
                Specification::where('id', $cur_spec->id)->delete();
            }
        }
    }


    public function saveImage(StoreCategoryRequest $request): void
    {
        $path = 'storage/images/categories/' . $request->input('slug') . '.jpg';

        if (file_exists($path)) {
            unlink($path);
        }

        $source_path = $request->file('image')->path();
        $image = Image::make($source_path);
        $image->save($path, 85);
    }


    public function deleteImage(string $slug): void
    {
        $path = 'storage/images/categories/' . $slug . '.jpg';

        if (file_exists($path)) {
            unlink($path);
        }
    }


    /**
     * Gets possible sort numbers as a collection for a new category.
     *
     * @param $categories
     * @param int $parent_id
     * @return Collection
     */
    public function getSortCollection($categories, int $parent_id): Collection
    {
        $root_sort_num = $categories->where('parent_id', $parent_id)->count() + 1;
        $root_sort = [];
        for ($i=0; $i<$root_sort_num; $i++) {
            $root_sort_obj = new \stdClass();
            $root_sort_obj->sort = $i + 1;
            array_push($root_sort, $root_sort_obj);
        }
        return new Collection($root_sort);
    }
}
