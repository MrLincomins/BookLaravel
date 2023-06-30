<?php

namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\Genre;
use Illuminate\Http\Request;

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



}
