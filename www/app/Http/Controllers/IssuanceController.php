<?php

namespace App\Http\Controllers;


use App\Models\Books;
use App\Models\Surrender;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserBookService;
use Illuminate\Support\Facades\Auth;

class IssuanceController extends BookTransactionController
{
    public function issueFromTransaction(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return response()->json(parent::issuanceBook($request->input('iduser'), $id));
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
        $idIssuance = $request->get('issuance');
        $idBook = $request->get('book');

        if (Surrender::find($idIssuance)->exists()) {
            Surrender::destroy($idIssuance);
            if (Books::find($idBook)->exists()) {
                $book = Books::find($idBook);
                $book->count = $book->count + 1;
                $book->save();
            }
            (new UserBookService)->editUserBook($idIssuance);
        } else {
            return response()->json(['message' => 'У пользователя нету книг', 'status' => 'error']);
        }

        return response()->json(['message' => 'Книга успешно возвращена в библиотеку', 'status' => 'success']);
    }
}
