<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use App\Services\Site\CategoryService;
use App\Services\Admin\CategoryService as AdminCategoryService;
use App\Services\Admin\ImageService as AdminImageService;
use App\Http\Requests\Admin\BaseRequest;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService): View
    {
        $category_tree = $categoryService->buildMenu();

        return view('admin.categories.index', compact('category_tree'));
    }


    public static function create(
        BaseRequest $request,
        CategoryService $categoryService,
        AdminCategoryService $admCategoryService,
    ): View {
        $categories = $categoryService->getCategories();
        $parent_id = $request->query('parent') ?? 0;
        $root_sort = $admCategoryService->getSortCollection($categories, $parent_id);

        return view('admin.categories.create', compact(
            'categories',
            'parent_id',
            'root_sort'
        ));
    }


    public static function store(
        StoreCategoryRequest $request,
        AdminCategoryService $admCategoryService,
        AdminImageService $admImageService
    ) {
        $category = $admCategoryService->saveCategory($request);
        $admCategoryService->saveSpecifications($request, $category->id);

        if ($request->hasFile('image')) {
            $admImageService->saveImageBySlug(
                'categories',
                $request->file('image'),
                $request->input('slug')
            );
        }

        $request->flashMessage('Категория ' . $category->name . ' создана.');

        return redirect()->route('admin.categories');
    }


    public static function edit(
        CategoryService $categoryService,
        AdminCategoryService $admCategoryService,
        string $id
    ): View {
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


    public static function update(
        StoreCategoryRequest $request,
        AdminCategoryService $admCategoryService,
        AdminImageService $admImageService,
        int $id
    ) {
        $message = '';

        if ($request->has('name')) {
            $admCategoryService->updateSortOrder($request);

            $validated = $request->validated();
            Category::where('id', $id)->update($validated);
            $admImageService->renameImageBySlug(
                'categories',
                $validated['slug'],
                $request->input('slug_old')
            );

            $message = 'Категория обновлена.';
        }

        if ($request->has('specs')) {
            $input_specs = $admCategoryService->getInputSpecs($request->input('specs'));
            $admCategoryService->updateSpecs($input_specs, $id);
            $message = 'Характеристики обновлены.';
        }

        if ($request->hasFile('image')) {
            $admImageService->saveImageBySlug(
                'categories',
                $request->file('image'),
                $request->input('slug')
            );

            $message = 'Изображение обновлено.';
        }

        $request->flashMessage($message);

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        AdminCategoryService $admCategoryService,
        AdminImageService $admImageService,
        int $id
    ) {
        $category = Category::find($id);
        $category->delete();
        $admCategoryService->updateSortWhenDeleting($category->parent_id, $category->sort);
        $admImageService->deleteImageBySlug('categories', $category->slug);

        $request->flashMessage('Категория ' . $category->name . ' удалена.');

        return redirect()->route('admin.categories');
    }
}
