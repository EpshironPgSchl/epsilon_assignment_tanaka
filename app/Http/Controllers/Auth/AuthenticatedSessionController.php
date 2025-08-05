<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to find the user including trashed ones
        $user = \App\Models\User::withTrashed()
            ->where('email', $request->get('email'))
            ->first();

        // If the user is soft-deleted and password is correct, restore and login
        if ($user && $user->trashed() && Hash::check($request->get('password'), $user->password)) {
            $user->restore();

            Auth::login($user, $request->boolean('remember'));

            $request->session()->regenerate();

            return redirect()->intended(route('posts.index'));
        }

        // Otherwise, proceed with standard authentication flow
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('posts.index', absolute: false));
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
