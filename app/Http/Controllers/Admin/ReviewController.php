<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public static function edit(string $id): View
    {
        $review_id = $id;

        return view('admin.reviews.edit', compact('review_id'));
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
