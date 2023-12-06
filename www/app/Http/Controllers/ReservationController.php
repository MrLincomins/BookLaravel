<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Reserve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reserveBook(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $date = now()->addDays(2)->format('Y-m-d');

        Reserve::create([
            'idbook' => $id,
            'iduser' => (Auth::user())->id,
            'date' => $date,
            'unique_key' => Auth::user()->unique_key
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
        $unique_key = Auth::user()->unique_key;
        $reserves = Reserve::all()->toArray();
        $books = Books::whereIn('id', collect($reserves)->pluck('idbook'))->where('library_id', $unique_key)->get()->toArray();
        $users = User::whereIn('id', collect($reserves)->pluck('iduser'))->where('unique_key', $unique_key)->get()->toArray();

        return view('allReserve', compact('reserves', 'books', 'users'));
    }
}
