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
        'http://localhost/register',
        'http://localhost/login',
        'http://localhost/books/year',
        'http://localhost/books/reserve/*',
        'http://localhost/books/surrender/*',
        'http://localhost/books/surrender/*',
        'http://localhost/library/settings',
        'http://localhost/library/entrance',
        'http://localhost/library',
        'http://localhost/library/setting',
        'http://localhost/library/roles',
        'http://localhost/*',
        //Исправить
    ];
}
