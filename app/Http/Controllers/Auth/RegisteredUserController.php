<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Site\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request, UserService $userService): View
    {
        $guest_settings = $userService->getGuestActivitySettings($request);

        return view('auth.register', compact('guest_settings'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(
        Request $request,
        UserService $userService
    ): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:100', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $userService->moveGuestActivitySettings($request);

        $request->session()->flash('message', [
            'type' => 'info',
            'content' => 'На вашу почту была отправлена ссылка для подтверждения адреса электронной почты.',
            'align' => 'center',
        ]);

        Log::channel('events')->info('Зарегистрирован новый пользователь: ' . $user->name . '.');

        return redirect(RouteServiceProvider::HOME);
    }
}
