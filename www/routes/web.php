<?php

use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['web', 'auth']], function () {

// Книги
    Route::get('/books', [BooksController::class, 'index']);
    Route::get('/books/create', [BooksController::class, 'create']);
    Route::post('/books/create', [BooksController::class, 'store']);
    Route::delete('/books/{id}', [BooksController::class, 'delete']);
    Route::get('/books/edit/{id}', [BooksController::class, 'edit']);
    Route::post('/books/edit/{id}', [BooksController::class, 'refactor']);
    Route::get('/books/search', [BooksController::class, 'search']);
    Route::get('/books/year', function () {
        return view('yearSearch');
    });
    Route::post('/books/year', [BooksController::class, 'yearSearch']);
    Route::get('/books/reserve/{id}', [BooksController::class, 'reserveBookForm']);
    Route::post('/books/reserve/{id}', [BooksController::class, 'reserveBook']);
    Route::get('/books/reserve', [BooksController::class, 'allReserve']);

    Route::get('/books/surrender/{id}', [BooksController::class, 'surrenderBookForm']);
    Route::post('/books/surrender/{id}', [BooksController::class, 'surrenderBook']);
    Route::get('/books/surrender', [BooksController::class, 'allSurrender']);


// Жанры
    Route::get('/books/genre', function () {
        return view('createGenre');
    });
    Route::get('/books/genre/show', [GenreController::class, 'showGenre']);

    Route::post('/books/genre', [GenreController::class, 'storeGenre']);
    Route::delete('/books/genre/{id}', [GenreController::class, 'deleteGenre']);

// Пользователи

    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/account', [UserController::class, 'account']);

// Админ панель

    Route::get('/library/entrance', function () {
        return view('libraryEntrance');
    })->name('LibraryEntrance');

    Route::post('/library/entrance', [LibraryController::class, 'libraryEntrance']);


    Route::get('/library', function () {
        return view('createLibrary');
    });

    Route::post('/library', [LibraryController::class, 'storeLibrary']);

    Route::get('/library/settings', function () {
        return view('globalSettings');
    });

    Route::post('/library/settings', [LibraryController::class, 'globalSettings']);

    Route::get('/library/roles', [LibraryController::class, 'createRole']);


    Route::post('/library/roles', [LibraryController::class, 'storeRole']);

    Route::get('/library/users', [LibraryController::class, 'allUsers']);

    Route::post('/library/users/{id}', [LibraryController::class, 'kickUser']);

});

Route::group(['middleware' => 'web'], function () {
    // Регистрация и вход

    Route::get('/register', function () {
        return view('register');
    });
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'login']);

});

