<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $cart = session('cart');
        $orders = json_decode($request->cookie('ord'));

        return view('auth.login', compact('cart', 'orders'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(
        LoginRequest $request,
        CartService $cartService,
        OrderService $orderService
    ): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->boolean('move_cart_and_orders')) {
            $user_id = $request->user()->id;
            $user_email = $request->user()->email;
            $cartService->moveCartFromSessionToDB($user_id);
            $orderService->moveOrdersFromCookie($user_id, $user_email);
        }

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
