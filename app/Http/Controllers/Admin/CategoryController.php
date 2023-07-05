<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Site\CategoryService;
use App\Services\Admin\CategoryService as AdminCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService): View
    {
        $category_tree = $categoryService->buildMenu();

        return view('admin.categories.index', compact('category_tree'));
    }

    public static function create(): View
    {
        return view('admin.categories.create');
    }


    public static function store()
    {
        // return
    }


    public static function edit(
        CategoryService $categoryService,
        AdminCategoryService $admCategoryService,
        string $id
    ): View
    {
        $categories = $categoryService->getCategories();
        $category = $categories->firstWhere('id', $id);
        if (!$category) abort(404);
        $children = $categoryService->getChildren($id);

        $branch = $categoryService->getBranchFrom($id);
        $excluding_branch = $categories->filter(function($category) use ($branch, $id) {
            return $branch->doesntContain('id', $category->id) && $category->id !== intval($id);
        });

        $siblings = $categories->where('parent_id', $category->parent_id)->sortBy('sort');

        $spec_list = $admCategoryService->getCategorySpecList($id);

        return view('admin.categories.edit', compact(
            'category',
            'children',
            'excluding_branch',
            'siblings',
            'spec_list',
        ));
    }


    public static function update()
    {
        // return
    }


    public static function destroy(string $id)
    {
        return response('Категория ' . $id . ' будет удалена!');
    }
}
