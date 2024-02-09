<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StoreBookRequest;
use App\Models\Books;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController
{

    public function index(Request $request): \Illuminate\Contracts\View\View
    {

        $libraryId = Auth::user()->unique_key;
        $books = Books::where('library_id', $libraryId)->get(); // 8 книг на странице

        return view('allBooks', compact('books'));
    }

    //Показывает книги на странице, по 10 штук на каждую

    public function create(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $genres = Genre::where('library_id', $unique_key)->get();
        return view('createBooks', compact('genres'));
    }

    // Берёт жанры и перенаправляет на страницу

    public function store(StoreBookRequest $request): \Illuminate\Http\JsonResponse
    {
        $unique_key = Auth::user()->unique_key;

        $picture = "https://pictures.abebooks.com/isbn/" . $request->input('isbn') . "-us-300.jpg";
        $book = Books::where('isbn', $request->input('isbn'))->where('library_id', $unique_key)->first();
        if (!$book) {
            Books::create([
                'tittle' => $request->input('tittle'),
                'author' => $request->input('author'),
                'year' => $request->input('year'),
                'isbn' => $request->input('isbn'),
                'genre' => $request->input('genre'),
                'count' => $request->input('count'),
                'picture' => $picture,
                'library_id' => $unique_key
            ]);
        } elseif ($book) {
            return response()->json(['message' => 'Книга уже есть на сервере', 'status' => 'warning'], 200);
        }
        return response()->json(['message' => 'Вы успешно добавили книгу', 'status' => 'success'], 200);

    }

    // Добавляет книги в бд


    public function delete($id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(['status' => false, 'message' => 'Книга не найдена']);
        }

        $book->delete();

        return response()->json(['status' => true, 'message' => 'Книга успешно удалена']);
    }

    // Удаляет книгу

    public function edit(Request $request, $id): \Illuminate\Contracts\View\View
    {
        $book = Books::find($id);
        $genres = Genre::all('genre');
        return view('editBook', compact('book', 'genres'));
    }

    // Открывает форму для изменения книги

    public function refactor(StoreBookRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $book = Books::find($id);
        if ($book) {
            $book->tittle = $request->input('tittle');
            $book->author = $request->input('author');
            $book->year = $request->input('year');
            $book->isbn = $request->input('isbn');
            $book->count = $request->input('count');
            $book->genre = $request->input('genre');
            $book->save();
        } else {
            return response()->json(['message' => 'Книга не была найдена', 'status' => 'error'], 200);
        }
        return response()->json(['message' => 'Вы успешно изменили книгу', 'status' => 'success'], 200);

    }

    // Изменяет книгу

    public function search(Request $request): \Illuminate\Contracts\View\View
    {
        $tittle = $request->get('tittle');
        $books = Books::where('tittle', 'like', '%' . $tittle . '%')->get();
        return view('searchBook', compact('books'));
    }

    // Поиск книги

    public function yearSearch(Request $request): \Illuminate\Http\JsonResponse
    {
        $first = $request->input('first');
        $second = $request->input('second');
        $books = Books::whereBetween('year', [(int)$first, (int)$second])->get();
        return response()->json($books);
    }


    public function bookTest(Request $request)
    {
        $libraryId = Auth::user()->unique_key;
        $books = Books::where('library_id', $libraryId)->get();

        $genres = $books->pluck('genre')->unique()->toArray();
        if ($genres) {

            $randomGenres = array_rand($genres, min(3, count($genres)));

            $randomBooks = [];
            foreach ($randomGenres as $genreIndex) {
                $genre = $genres[$genreIndex];
                $genreBooks = $books->where('genre', $genre)->shuffle()->take(6)->toArray();
                $randomBooks[] = [
                    'name' => $genre,
                    'books' => $genreBooks,
                    'start' => 0,
                ];
            }

            return view('booksTest', compact('randomBooks'));
        } else {
            $randomBooks = [];
            return view('booksTest', compact('randomBooks'));

        }
    }


}
