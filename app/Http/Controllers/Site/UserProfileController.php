<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        return view('layout.user-profile', compact('user'));
    }


    public function update(
        ProfileUpdateRequest $request,
        UserService $userService
    )
    {
        $message = '';

        if ($request->hasFile('user_image')) {

            $userService->saveUserImage($request);

        } elseif ($request->has('email')) {
            $request->user()->update($request->validated());
            $message = 'Профиль успешно обновлён.';

        } elseif ($request->has('new_password')) {
            $validated = $request->validated();
            $request->user()->update([
                'password' => Hash::make($validated['new_password']),
            ]);
            $message = 'Пароль успешно обновлён.';
        }

        if ($message) {
            $request->session()->flash('message', [
                'type' => 'info',
                'content' => $message,
                'align' => 'center',
            ]);
        }

        return back();
    }
}
