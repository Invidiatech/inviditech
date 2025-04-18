<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            Log::info('AdminMiddleware: User not authenticated');
            return redirect()->route('home')->with('error', 'Please login');
        }

        // Get the current user
        $user = Auth::user();

        // Log user details for debugging
        Log::info('AdminMiddleware - User Details:', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'No role column',
            'is_admin' => method_exists($user, 'isAdmin') ? $user->isAdmin() : 'Method not found'
        ]);

        // Check if user is an admin
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Log unauthorized access attempt
        Log::warning('AdminMiddleware: Unauthorized access attempt', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        // Redirect or return unauthorized access
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
}