<?php


namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection;

class CategoryService
{
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
        $category_specs = CategoryService::getCategorySpecs($category_id);

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
            $out .= $is_filter . $spec->name . $units . "\n";
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
}
