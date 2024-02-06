<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLibraryCreation
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(Auth::user()->unique_key)) {
            return $next($request);
        }

        abort(403, 'Вход запрещён. Для начала нужно создать библиотеку');
    }
}
