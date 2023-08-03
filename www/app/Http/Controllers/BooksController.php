<?php

namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\Genre;
use App\Models\Library;
use App\Models\Surrender;
use App\Models\User;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BooksController
{
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
<<<<<<< Updated upstream
        $books = Books::paginate(10);
=======
        $libraryId = Auth::user()->unique_key;
        $books = Books::where('library_id', 'like', '%"'.$libraryId.'"%')->get();

        foreach ($books as $book) {
            $libraryIds = json_decode($book->library_id, true);
            $book->count = $libraryIds[$libraryId] ?? 0;
        }

>>>>>>> Stashed changes
        return view('allBooks', compact('books'));
    }
    //Показывает книги на странице, по 10 штук на каждую

    public function create(Request $request): \Illuminate\Contracts\View\View
    {
        $genres = Genre::all('genre');
        return view('createBooks', compact('genres'));
    }
    // Берёт жанры и перенаправляет на страницу

    public function store(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $unique_key = Auth::user()->unique_key;

        $rules = [
            'tittle' => 'required|max:200',
            'author' => 'required|max:200',
            'year' => 'required|numeric|max:5',
            'isbn' => 'required|max:13',
            'genre' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

//        JSON Ответ
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->errors()], 400);
//        }

<<<<<<< Updated upstream
        $picture = "https://pictures.abebooks.com/isbn/" . $request->input('isbn') . "-us-300.jpg";
        $book = Books::create([
            'tittle' => $request->input('tittle'),
            'author' => $request->input('author'),
            'year' => $request->input('year'),
            'isbn' => $request->input('isbn'),
            'count' => $request->input('count'),
            'genre' => $request->input('genre'),
            'picture' => $picture
        ]);
        return redirect('/books/create');
=======
        $book = Books::where('isbn', $request->input('isbn'))->first();

        if(!$book) {
            $picture = "https://pictures.abebooks.com/isbn/" . $request->input('isbn') . "-us-300.jpg";
            Books::create([
                'tittle' => $request->input('tittle'),
                'author' => $request->input('author'),
                'year' => $request->input('year'),
                'isbn' => $request->input('isbn'),
                'genre' => $request->input('genre'),
                'picture' => $picture,
                'library_id' => json_encode([$unique_key => $request->input('count')])
            ]);

            return response()->json(['message' => 'Вы успешно добавили книгу', 'status' => true], 400);

        } else {

            if (isset($libraryIds[$unique_key])) {
                $libraryIds[$unique_key]++;
            } else {
                $libraryIds[$unique_key] = 1;
            }

            $book->library_id = json_encode($libraryIds);
            $book->save();

            return response()->json(['message' => 'Книга уже была в архивах, она была подгружена', 'status' => true], 400);
        }
>>>>>>> Stashed changes
    }
    // Добавляет книги в бд


    public function delete(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
<<<<<<< Updated upstream
        Books::destroy($id);
        return redirect('/books');
=======
        $unique_key = Auth::user()->unique_key;

        $book = Books::find($id);

        $libraryIds = json_decode($book->library_id, true);

        $index = array_search($unique_key, $libraryIds);
        if ($index !== false) {
            unset($libraryIds[$index]);
        }

        $book->library_id = json_encode(array_values($libraryIds));
        $book->save();

        return response()->json(['status' => true, 'message' => 'Вы успешно удалили книгу']);
>>>>>>> Stashed changes
    }
    // Удаляет книгу

    public function edit(Request $request, $id): \Illuminate\Contracts\View\View
    {
        $book = Books::find($id);
        $genres = Genre::all('genre');
        return view('editBook', compact('book', 'genres'));
    }
    // Открывает форму для изменения книги

    public function refactor(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $rules = [
            'tittle' => 'required|max:200',
            'author' => 'required|max:200',
            'year' => 'required|numeric|max:5',
            'isbn' => 'required|max:13',
            //'count' => 'required|numeric|max:9999',
            'genre' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        // JSON

        $book = Books::find($id);
        $book->tittle = $request->input('tittle');
        $book->author = $request->input('author');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        //$book->count = $request->input('count');
        $book->genre = $request->input('genre');
        $book->save();
        return redirect('/books');
    }
    // Изменяет книгу

    public function search(Request $request): \Illuminate\Contracts\View\View
    {
        $tittle = $request->get('tittle');
        $books = Books::where('tittle', 'like', '%' . $tittle . '%')->get();
        return view('searchBook', compact('books'));
    }
    // Поиск книги

    public function yearSearch(Request $request): \Illuminate\Contracts\View\View
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
            'idbook' => $id,
            'iduser' => (Auth::user())->id,
            'date' => $date
        ]);

        return redirect('/books');
    }

    public function reserveBookForm(Request $request, $id): \Illuminate\Contracts\View\View
    {
        $book = Books::find($id);
        return view('reserveBook', compact('book'));
    }


    public function allReserve(Request $request): \Illuminate\Contracts\View\View
    {
        $reserves = Reserve::all()->toArray();
        $books = Books::whereIn('id', collect($reserves)->pluck('idbook'))->get()->toArray();
        $users = User::whereIn('id', collect($reserves)->pluck('iduser'))->get()->toArray();

        return view('allReserve', compact('reserves', 'books', 'users'));
    }

    public function surrenderBook(Request $request, $id)
    {
        $rules = [
            'iduser' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        // JSON

        $date = now()->addDays(7)->format('Y-m-d');

        Surrender::create([
            'idbook' => $id,
            'iduser' => $request->input('iduser'),
            'date' => $date
        ]);

        return redirect('/books');
    }

    public function surrenderBookForm(Request $request, $id)
    {
        $book = Books::find($id);
        return view('surrenderBook', compact('book'));

    }

    public function allSurrender(Request $request): \Illuminate\Contracts\View\View
    {
        $surrenders = Surrender::all()->toArray();
        $books = Books::whereIn('id', collect($surrenders)->pluck('idbook'))->get()->toArray();
        $users = User::whereIn('id', collect($surrenders)->pluck('iduser'))->get()->toArray();

        return view('allSurrender', compact('surrenders', 'books', 'users'));
    }





}
