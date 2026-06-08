<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Accepts a comma-separated list of role names (as stored in `roles.tipo`).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (! Auth::check()) {
            return redirect()->route('auth.showLogin');
        }

        $allowed = array_map('trim', explode(',', $roles));
        $userRole = optional(Auth::user()->role)->tipo;

        if (in_array($userRole, $allowed, true)) {
            return $next($request);
        }

        abort(403, 'No autorizado');
    }
}
