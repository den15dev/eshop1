<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        CategoryService $categoryService,
        ProductService $productService,
        ReviewService $reviewService,
        CartService $cartService,
        string $category_slug,
        string $product_slug
    ): View
    {
        $category = $categoryService->getCategories()->where('slug', $category_slug)->first();
        if (!$category) abort(404);

        $slug_parts = parse_slug($product_slug);

        $product_id = intval($slug_parts[1]);
        $product = $productService->getProduct($product_id);
        if ($product->category_id !== $category->id || $product->slug !== $slug_parts[0]) abort(404);

        $rating = $reviewService->getMarks($product);

        $in_cart = $cartService->isInCart($product_id);

        $user_id = Auth::id();
        $reviews = $product->reviews()->with(['reactions:id,review_id,user_id,up_down', 'user:id,name'])->orderBy('created_at')->get();
        $reviews = $reviewService->countReactions($reviews, $user_id);

        $is_reviewed = $reviewService->isReviewedBy($product_id, $user_id);

        $bread_crumb = $categoryService->getBreadCrumb($product);

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')), $product->id);
        $productService->addToRecentlyViewed($product_id, 8);

        return view('layout.product', compact(
            'product',
            'bread_crumb',
            'rating',
            'in_cart',
            'reviews',
            'user_id',
            'is_reviewed',
            'category_slug',
            'product_slug',
            'recently_viewed'
        ));
    }
}
