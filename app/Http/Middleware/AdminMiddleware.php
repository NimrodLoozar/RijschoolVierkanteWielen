<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has an active admin role
        $user = Auth::user();

        if (!$user || !$user->roles()->where('name', 'admin')->where('is_active', true)->exists()) {
            // If the user is not an admin or the role is inactive, deny access
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
