<?php

namespace App\Http\Controllers;


use App\Models\Books;
use App\Models\Surrender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssuanceController extends Controller
{
    public function issuanceBook(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $date = now()->addDays(7)->format('Y-m-d');

        Surrender::create([
            'idbook' => $id,
            'iduser' => $request->input('iduser'),
            'date' => $date,
            'unique_key' => Auth::user()->unique_key
        ]);

        return redirect('/books');
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
}
