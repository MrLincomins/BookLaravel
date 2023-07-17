<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'web'], function () {

// Книги
    Route::get('/books', [BooksController::class, 'index']);
    Route::get('/books/create', [BooksController::class, 'create']);
    Route::post('/books/create', [BooksController::class, 'store']);
    Route::delete('/books/delete/{id}', [BooksController::class, 'delete']);
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
    Route::get('/books/genre', [GenreController::class, 'showGenre']);
    Route::post('/books/genre', [GenreController::class, 'storeGenre']);

// Пользователи
    Route::get('/register', function () {
        return view('register');
    });
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/account', function () {
        return view('account');
    });
// Админ панель
    Route::get('/settings', function () {
        return view('globalSettings');
    });

    Route::post('/settings', [AdminController::class, 'globalSettings']);



});
