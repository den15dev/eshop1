<?php


namespace App\Services;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    /**
     * Counts reactions and detects if the reaction needs to be hilighted.
     * Embeds 'reactions_counted' and 'hilighted' properties into the review collection.
     *
     * @param Collection $reviews
     * @param int|null $current_user_id
     * @return Collection - the same review collection with an additional 'reactions_counted'
     *                      (array with two elements) and 'hilighted' (0, 1, or 'none') properties.
     */
    public function countReactions(Collection $reviews, int|null $current_user_id): Collection
    {
        foreach ($reviews as $review) {
            $review->reactions_counted = $review->reactions->countBy(function ($reaction) {
                return $reaction->up_down;
            })->all();

            $r_cnt = $review->reactions_counted;
            if (!isset($r_cnt[0])) $r_cnt[0] = 0;
            if (!isset($r_cnt[1])) $r_cnt[1] = 0;
            $review->reactions_counted = $r_cnt;

            $review->hilighted = 'none';
            if ($current_user_id) {
                $hilighted = $review->reactions->firstWhere('user_id', $current_user_id);
                if ($hilighted) $review->hilighted = $hilighted->up_down;
            }
        }
        return $reviews;
    }


/*
    public function getReviews(Product $product): Collection
    {
        return $product->reviews()
            ->with(['user:id,name', 'reactions' => function ($q) {
                $q->selectRaw('review_id, up_down, count(*) as r_count')
                    ->groupByRaw('review_id, up_down');
            }])->get();
    }
*/


    /**
     * Gets number of marks from 1 to 5. The first element is the max number
     * for calculation of a bar length.
     *
     * @param Product $product
     * @return array|null - six elements array or null if no reviews yet.
     */
    public function getMarks(Product $product): array|null
    {
        $rating_arr = null;

        $rating_count = $product->reviews()
            ->selectRaw('mark, COUNT(*) as num')
            ->groupBy('mark')
            ->orderBy('mark', 'desc')
            ->get();

        if (count($rating_count)) {
            $max_num_mark = $rating_count->sortByDesc('num', SORT_NUMERIC)->first()->num;

            $rating_arr = [$max_num_mark, 0, 0, 0, 0, 0];

            foreach ($rating_count as $item) {
                $rating_arr[$item->mark] = $item->num;
            }
        }

        return $rating_arr;
    }



    public function createReview(Request $request, int $user_id): void
    {
        DB::transaction(function () use ($user_id, $request) {
            // Save a review
            $review = new Review();
            $review->user_id = $user_id;
            $review->product_id = $request->product_id;
            $review->term = $request->term_of_use;
            $review->mark = $request->mark;
            if ($request->pros) $review->pros = $request->pros;
            if ($request->cons) $review->cons = $request->cons;
            if ($request->comment) $review->comnt = $request->comment;
            $review->save();

            // Get new rating
            $rating = DB::table('reviews')->selectRaw('COUNT(mark) AS vote_num, AVG(mark) AS rating')
                ->where('product_id', $request->product_id)
                ->first();

            // Update rating on the product
            DB::table('products')
                ->where('id', $request->product_id)
                ->update(['rating' => $rating->rating, 'vote_num' => $rating->vote_num]);
        }, 3);
    }



    /**
     * Checks if given product has been already reviewed by current user.
     *
     * @param int $product_id
     * @param int $user_id
     * @return bool
     */
    public function isReviewedBy(int $product_id, int|null $user_id): bool
    {
        return boolval($is_reviewed = DB::table('reviews')
            ->select('user_id')
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->count());
    }
}
