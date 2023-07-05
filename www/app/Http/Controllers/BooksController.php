<?php

namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\Genre;
use App\Models\User;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $books = Books::paginate(10);
        return view('allBooks', compact('books'));
    }
    //Показывает книги на странице, по 10 штук на каждую

    public function create(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $genres = Genre::all('genre');
        return view('createBooks', compact('genres'));
    }
    // Берёт жанры и перенаправляет на страницу

    public function store(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $picture = "https://pictures.abebooks.com/isbn/" . $request->input('isbn') . "-us-300.jpg";
        $genres = Genre::all('genre');

        $book = Books::create([
            'tittle' => $request->input('tittle'),
            'author' => $request->input('author'),
            'year' => $request->input('year'),
            'isbn' => $request->input('isbn'),
            'count' => $request->input('count'),
            'genre' => $request->input('genre'),
            'picture' => $picture
        ]);
        return view('createBooks', compact('book', 'genres'));
    }
    // Добавляет книги в бд


    public function delete(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        Books::destroy($id);
        return redirect('/books');
    }
    // Удаляет книгу

    public function edit(Request $request, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $book = Books::find($id);
        $genres = Genre::all('genre');
        return view('editBook', compact('book', 'genres'));
    }
    // Открывает форму для изменения книги

    public function refactor(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $book = Books::find($id);
        $book->tittle = $request->input('tittle');
        $book->author = $request->input('author');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        $book->count = $request->input('count');
        $book->genre = $request->input('genre');
        $book->save();
        return redirect('/books');
    }
    // Изменяет книгу

    public function search(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $tittle = $request->get('tittle');
        $books = Books::where('tittle', 'like', '%' . $tittle . '%')->get();
        return view('searchBook', compact('books'));
    }
    // Поиск книги

    public function yearSearch(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $first = $request->input('first');
        $second = $request->input('second');
        $books = Books::whereBetween('year', [(int)$first, (int)$second])->get();
        return view('yearSearch', compact('books'));
    }

    public function reserveBook(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $date = now()->addDays(2)->format('Y-m-d');

        Reserve::create([
            'idbook' => $request->input('idbook'),
            'iduser' => auth()->id(),
            'date' => $date
        ]);

        return redirect('/books');
    }


    public function allReserve(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $reserves = Reserve::all();
        $books = Books::whereIn('id', $reserves->pluck('idbook'))->get();
        $users = User::whereIn('id', $reserves->pluck('iduser'))->get();

        return view('yearSearch', compact('books', 'users', 'reserves'));
    }



}
