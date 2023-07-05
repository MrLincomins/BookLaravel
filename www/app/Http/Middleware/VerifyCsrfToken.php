<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'http://localhost/books/genre',
        'http://localhost/books/create',
        'http://localhost/books/delete/*',
        'http://localhost/books/edit/*',
        //Исправить
    ];
}
