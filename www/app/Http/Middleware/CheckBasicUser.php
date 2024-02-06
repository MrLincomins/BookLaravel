<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBasicUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (int)Auth::user()->status === 2) {
            return $next($request);
        }

        abort(403, 'Вход запрещён. Только ученики могут сюда зайти');
    }
}
