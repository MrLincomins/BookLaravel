<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Reserve;
use App\Models\Surrender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reserveBook(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        if (Reserve::where('iduser', (Auth::user())->id)->count() == 0) {
            $date = now()->addDays(2)->format('Y-m-d');

            $book = Books::find($id);
            if ($book->count > 0) {
                $book->count = $book->count - 1;
                $book->save();

                Reserve::create([
                    'idbook' => $id,
                    'iduser' => (Auth::user())->id,
                    'date' => $date,
                    'unique_key' => Auth::user()->unique_key
                ]);
            }
        }
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

    public function issuanceReservedBook(Request $request): \Illuminate\Http\JsonResponse
    {
        if(Surrender::where('iduser', $request->get('user'))->count() < 0) {
            Reserve::destroy($request->get('reserve'));

            $date = now()->addDays(7)->format('Y-m-d');
            Surrender::create([
                'idbook' => $request->get('book'),
                'iduser' => $request->get('user'),
                'date' => $date,
                'unique_key' => Auth::user()->unique_key
            ]);

            return response()->json('true');
        } else {
            return response()->json('false');
        }
    }

    public function deleteReservation(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        Reserve::destroy($id);

        return response()->json('true');
    }
}
