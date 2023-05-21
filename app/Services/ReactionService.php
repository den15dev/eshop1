<?php


namespace App\Services;

use App\Models\Reaction;
use Illuminate\Support\Facades\DB;

class ReactionService
{
    public function __construct(
        private int $review_id,
        private int $user_id,
        private int $up_down
    )
    {}

    public function createReaction(): void
    {
        $reaction = new Reaction();
        $reaction->review_id = $this->review_id;
        $reaction->user_id = $this->user_id;
        $reaction->up_down = $this->up_down;
        $reaction->save();
    }


    public function updateReaction(): int
    {
        return DB::table('reactions')
            ->where('review_id', $this->review_id)
            ->where('user_id', $this->user_id)
            ->update(['up_down' => $this->up_down]);
    }


    public function deleteReaction(): int
    {
        return DB::table('reactions')
            ->where('review_id', $this->review_id)
            ->where('user_id', $this->user_id)
            ->delete();
    }
}
