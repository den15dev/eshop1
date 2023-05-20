<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, ReviewService $reviewService)
    {
        $user_id = Auth::id();
        if ($user_id) {
            $reviewService->createReview($request, $user_id);
            $message = 'Спасибо! Ваш отзыв успешно опубликован.';
        } else {
            $request->flash();
            $message = 'Ваша сессия устарела. Пожалуйста, войдите на сайт заново, чтобы оставить отзыв.';
        }

        $request->session()->flash('message', ['type' => 'info', 'content' => $message]);

        return back();
    }
}
