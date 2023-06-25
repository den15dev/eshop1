<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Site\CategoryService;
use Illuminate\Http\Request;
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


    public static function edit(string $id): View
    {
        $category_id = $id;

        return view('admin.categories.edit', compact('category_id'));
    }


    public static function update()
    {
        // return
    }


    public static function destroy()
    {
        // return
    }
}
