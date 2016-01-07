<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return $this->authenticated();
        }

        return $next($request);
    }

    /**
     * Redirect after authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param App\Models\User          $user
     *
     * @return Illuminate\Support\Facades\Redirect
     */
    protected function authenticated()
    {
        return redirect()->intended(url('/home'));
    }
}
