<?php


namespace App\Services\Admin;


use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
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
