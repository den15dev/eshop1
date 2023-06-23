<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Site\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request, UserService $userService): View
    {
        $guest_settings = $userService->getGuestActivitySettings($request);

        return view('auth.login', compact('guest_settings'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(
        LoginRequest $request,
        UserService $userService
    ): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $userService->moveGuestActivitySettings($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
