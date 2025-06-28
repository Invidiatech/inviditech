<?php

namespace App\Http\Controllers\Seo\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\seo\SeoLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Check if user is already authenticated with SEO guard
        if (Auth::guard('seo')->check()) {
            return redirect()->route('seo.dashboard');
        }

        return view('seo.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(SeoLoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        
        return redirect()->intended(route('seo.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('seo')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('seo.login');
    }
}