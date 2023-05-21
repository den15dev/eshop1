<?php

namespace App\Http\Livewire;

use App\Services\ReactionService;
use Livewire\Component;

class Reactions extends Component
{
    const WRAP_CLASS = 'review_reaction';
    const WRAP_CLASS_ACTIVE = 'review_reaction_active';
    const WRAP_CLASS_DISABLED = 'review_reaction_disabled';
    const ICON_CLASS_UP = 'bi-hand-thumbs-up';
    const ICON_CLASS_DOWN = 'bi-hand-thumbs-down';
    const ICON_CLASS_UP_ACTIVE = 'bi-hand-thumbs-up-fill';
    const ICON_CLASS_DOWN_ACTIVE = 'bi-hand-thumbs-down-fill';

    public $review;
    public $review_id;
    public $userid; // Current authenticated user id (null if it's a guest)
    public bool $is_author;
    public $hilighted;
    public $wrap_class_up;
    public $wrap_class_down;
    public $icon_class_up;
    public $icon_class_down;
    public int $up_counted;
    public int $down_counted;

    public $out;

    public function mount()
    {
        $this->review_id = $this->review->id;
        $this->up_counted = $this->review->reactions_counted[1];
        $this->down_counted = $this->review->reactions_counted[0];
        $this->hilighted = $this->review->hilighted;
        $this->is_author = $this->userid === $this->review->user_id;

        $this->icon_class_up = self::ICON_CLASS_UP;
        $this->icon_class_down = self::ICON_CLASS_DOWN;

        if ($this->userid && !$this->is_author) {
            $this->wrap_class_up = self::WRAP_CLASS;
            $this->wrap_class_down = self::WRAP_CLASS;

            if ($this->review->hilighted === 1) {
                $this->wrap_class_up = self::WRAP_CLASS_ACTIVE;
                $this->icon_class_up = self::ICON_CLASS_UP_ACTIVE;
            } elseif ($this->review->hilighted === 0) {
                $this->wrap_class_down = self::WRAP_CLASS_ACTIVE;
                $this->icon_class_down = self::ICON_CLASS_DOWN_ACTIVE;
            }
        } else {
            $this->wrap_class_up = self::WRAP_CLASS_DISABLED;
            $this->wrap_class_down = self::WRAP_CLASS_DISABLED;
        }

        $this->out = $this->review->id;
    }


    public function like()
    {
        $reactionService = new ReactionService($this->review_id, $this->userid, 1);

        if ($this->hilighted === 1) {

            $reactionService->deleteReaction();
            $this->wrap_class_up = self::WRAP_CLASS;
            $this->icon_class_up = self::ICON_CLASS_UP;
            $this->up_counted--;
            $this->hilighted = 'none';

        } elseif ($this->hilighted === 0) {

            $reactionService->updateReaction();
            $this->wrap_class_up = self::WRAP_CLASS_ACTIVE;
            $this->icon_class_up = self::ICON_CLASS_UP_ACTIVE;
            $this->up_counted++;
            $this->wrap_class_down = self::WRAP_CLASS;
            $this->icon_class_down = self::ICON_CLASS_DOWN;
            $this->down_counted--;
            $this->hilighted = 1;
        } else {

            $reactionService->createReaction();
            $this->wrap_class_up = self::WRAP_CLASS_ACTIVE;
            $this->icon_class_up = self::ICON_CLASS_UP_ACTIVE;
            $this->up_counted++;
            $this->hilighted = 1;
        }
    }


    public function dislike()
    {
        $reactionService = new ReactionService($this->review_id, $this->userid, 0);

        if ($this->hilighted === 1) {

            $reactionService->updateReaction();
            $this->wrap_class_down = self::WRAP_CLASS_ACTIVE;
            $this->icon_class_down = self::ICON_CLASS_DOWN_ACTIVE;
            $this->down_counted++;
            $this->wrap_class_up = self::WRAP_CLASS;
            $this->icon_class_up = self::ICON_CLASS_UP;
            $this->up_counted--;
            $this->hilighted = 0;
        } elseif ($this->hilighted === 0) {

            $reactionService->deleteReaction();
            $this->wrap_class_down = self::WRAP_CLASS;
            $this->icon_class_down = self::ICON_CLASS_DOWN;
            $this->down_counted--;
            $this->hilighted = 'none';
        } else {

            $reactionService->createReaction();
            $this->wrap_class_down = self::WRAP_CLASS_ACTIVE;
            $this->icon_class_down = self::ICON_CLASS_DOWN_ACTIVE;
            $this->down_counted++;
            $this->hilighted = 0;
        }
    }


    public function render()
    {
        return view('livewire.reactions');
    }
}
