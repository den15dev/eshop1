<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Models\Review;
use App\Services\Site\ReviewService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public static function edit(int $id): View
    {
        $review = Review::where('id', $id)
            ->with('product:id,name,slug,category_id')
            ->with('user:id,name')
            ->withCount(['reactions as down_votes' => function (Builder $query) {
                $query->where('up_down', 0);
            }])
            ->withCount(['reactions as up_votes' => function (Builder $query) {
                $query->where('up_down', 1);
            }])
            ->first();

        return view('admin.reviews.edit', compact('review'));
    }


    public static function update(
        BaseRequest $request,
        int $id
    ) {
        Review::where('id', $id)->update([
            'pros' => $request->input('pros'),
            'cons' => $request->input('cons'),
            'comnt' => $request->input('comnt'),
        ]);

        $request->flashMessage('Отзыв #' . $id . ' сохранён.');

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        ReviewService $reviewService,
        int $id
    ) {
        $review = Review::find($id);
        $review->delete();
        $reviewService->updateProductRating($request->input('product_id'));

        $request->flashMessage('Отзыв #' . $id . ' удалён.');

        return redirect()->route('admin.reviews');
    }
}
