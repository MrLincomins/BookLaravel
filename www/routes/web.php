<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Книги
Route::get('/books', [BooksController::class, 'index']);
Route::get('/books/create', [BooksController::class, 'create']);
Route::post('/books/create', [BooksController::class, 'store']);
Route::post('/books/delete/{id}', [BooksController::class, 'delete']);
Route::get('/books/edit/{id}', [BooksController::class, 'edit']);
Route::post('/books/edit/{id}', [BooksController::class, 'refactor']);
Route::get('/books/search', [BooksController::class, 'search']);


// Жанры
Route::get('/books/genre', [GenreController::class, 'showGenre']);
Route::post('/books/genre', [GenreController::class, 'storeGenre']);

// Пользователи

Route::get('/login', [UserController::class, 'login']);