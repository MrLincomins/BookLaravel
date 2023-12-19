<?php

namespace App\Http\Controllers;


use App\Models\Books;
use App\Models\Surrender;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserBookService;
use Illuminate\Support\Facades\Auth;

class IssuanceController extends Controller
{
    public function issuanceBook(Request $request, $id): \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\JsonResponse
    {
        $date = now()->addDays(7)->format('Y-m-d');

        $book = Books::find($id);
        if($book->count > 0)
        {
            $book->count = $book->count-1;
            $book->save();

            $surrender = Surrender::create([
                'idbook' => $id,
                'iduser' => $request->input('iduser'),
                'date' => $date,
                'unique_key' => Auth::user()->unique_key
            ]);

            (new UserBookService)->createUserBook($request->input('iduser'), $id, $surrender->id);

            return redirect('/books');
        } else {
            return response()->json('false');
        }
    }

    public function issuanceBookForm(Request $request, $id): \Illuminate\Contracts\View\View
    {
        $book = Books::find($id);
        return view('surrenderBook', compact('book'));

    }

    public function allIssuance(Request $request): \Illuminate\Contracts\View\View
    {
        $unique_key = Auth::user()->unique_key;
        $surrenders = Surrender::all()->toArray();
        $books = Books::whereIn('id', collect($surrenders)->pluck('idbook'))->where('library_id', $unique_key)->get()->toArray();
        $users = User::whereIn('id', collect($surrenders)->pluck('iduser'))->where('unique_key', $unique_key)->get()->toArray();

        return view('allSurrender', compact('surrenders', 'books', 'users'));
    }

    public function returningBook(Request $request): \Illuminate\Http\JsonResponse
    {
        Surrender::destroy($request->get('issuance'));
        $book = Books::find($request->get('book'));
        $book->count = $book->count+1;
        $book->save();

        (new UserBookService)->editUserBook($request->get('issuance'));

        return response()->json('true');
    }
}
