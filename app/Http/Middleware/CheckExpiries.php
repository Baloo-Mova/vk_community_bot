<?php

namespace App\Http\Middleware;

use Closure;

class CheckExpiries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (\Auth::check()) {
            $user = \Auth::user();
            if ($user->expiresIn < time()) {
                \Auth::logout();

                return redirect(route('vk_login'));
            }
        }

        return $next($request);
    }
}
