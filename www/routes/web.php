<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IssuanceController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReservationController;
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

    Route::middleware(['check.permissions:CREATE_BOOKS'])->group(function () {
        Route::get('/books/create', [BooksController::class, 'create']);
        Route::post('/books/create', [BooksController::class, 'store']);
    });

    Route::middleware(['check.permissions:DELETE_BOOKS'])->group(function () {
        Route::delete('/books/{id}', [BooksController::class, 'delete']);
    });

    Route::middleware(['check.permissions:CHANGE_BOOKS'])->group(function () {

        Route::get('/books/edit/{id}', [BooksController::class, 'edit']);
        Route::post('/books/edit/{id}', [BooksController::class, 'refactor']);
    });

    Route::get('/books/search', [BooksController::class, 'search']);
    Route::get('/books/year', function () {
        return view('yearSearch');
    });
    Route::post('/books/year', [BooksController::class, 'yearSearch']);

//Резервация книг

    Route::get('/books/reserve/{id}', [ReservationController::class, 'reserveBookForm']);
    Route::post('/books/reserve/{id}', [ReservationController::class, 'reserveBook']);

    Route::middleware(['check.permissions:ISSUE_RETURN_BOOKS'])->group(function () {
        Route::get('/books/reserve', [ReservationController::class, 'allReserve']);
        Route::post('/books/reserve', [ReservationController::class, 'issuanceReservedBook']);
        Route::delete('/books/reserve/{id}', [ReservationController::class, 'deleteReservation']);
    });

// Выдача, сбор книг у учеников

    Route::middleware(['check.permissions:ISSUE_RETURN_BOOKS'])->group(function () {
        Route::get('/books/surrender/{id}', [IssuanceController::class, 'issuanceBookForm']);
        Route::post('/books/surrender/{id}', [IssuanceController::class, 'issuanceBook']);
        Route::get('/books/surrender', [IssuanceController::class, 'allIssuance']);
        Route::post('/books/surrender', [IssuanceController::class, 'returningBook']);
    });

// Жанры
    Route::middleware(['check.permissions:CHANGE_BOOKS,DELETE_BOOKS'])->group(function () {

        Route::get('/books/genre', function () {
            return view('createGenre');
        });

        Route::get('/books/genre/show', [GenreController::class, 'showGenre']);

        Route::post('/books/genre', [GenreController::class, 'storeGenre']);
        Route::delete('/books/genre/{id}', [GenreController::class, 'deleteGenre']);
    });

// Пользователи

    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/account', [UserController::class, 'account']);

    Route::get('/notifications', [UserController::class, 'notificationsGet']);

    Route::delete('/notifications/{id}', [UserController::class, 'notificationsDelete']);

// Панель библиотекаря


    Route::get('/library/application', function () {
        return view('libraryApplication');
    });
    Route::post('/library/application', [LibraryController::class, 'libraryApplication']);
    Route::post('/library/get', [LibraryController::class, 'libraryGet']);


    Route::group(['middleware' => 'librarian'], function () {
        Route::get('/library/entrance', function () {
            return view('acceptApplications');
        });
        Route::post('/library/entrance', [LibraryController::class, 'libraryAcceptApplication']);
        Route::delete('/library/entrance', [LibraryController::class, 'libraryDeleteApplication']);
        Route::get('/library/entrance/get', [LibraryController::class, 'libraryGetApplications']);

        Route::post('/library/delete', [LibraryController::class, 'deleteLibrary']);


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

        Route::delete('/library/roles/{id}', [LibraryController::class, 'deleteRole']);

        Route::get('/library/logs', [LibraryController::class, 'allLogs']);

    });

    Route::middleware(['check.permissions:MANAGE_USERS'])->group(function () {

        Route::get('/library/users', [LibraryController::class, 'allUsers']);

        Route::post('/library/users', [LibraryController::class, 'assigningRole']);

        Route::delete('/library/users/{id}', [LibraryController::class, 'kickUser']);

    });
        // Админ панель
        //Route::get('/admin/permissions', [AdminController::class, 'createPermission']);

    Route::post('/notificationstest', [UserController::class, 'notificationTest']);
    Route::get('/notificationstest', function () {
        return view('notificationstest');
    });


});

    Route::group(['middleware' => 'web'], function () {

        Route::get('/', function () {
            return view('main');
        });

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

