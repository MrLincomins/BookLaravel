<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckLibrarian
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (int)Auth::user()->status === 1) {
            return $next($request);
        }

        abort(403, 'Вход запрещён. Только библиотекари могут сюда зайти');
    }
}
