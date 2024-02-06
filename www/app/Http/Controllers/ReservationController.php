<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Reserve;
use App\Models\Surrender;
use App\Models\User;
use App\Services\NotificationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends BookTransactionController
{
    public function reserveBook(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        if (Reserve::where('iduser', Auth::id())->count() == 0) {
            $date = now()->addDays(2)->format('Y-m-d');

            $book = Books::find($id);
            if ($book->count > 0) {
                $book->count = $book->count - 1;
                $book->save();

                $reserve = Reserve::create([
                    'idbook' => $id,
                    'iduser' => (Auth::user())->id,
                    'date' => $date,
                    'unique_key' => Auth::user()->unique_key
                ]);
            } else {
                return response()->json(['message' => 'К сожалению на данный момент книга отсутствует в библиотеке', 'status' => 'warning']);
            }
        } else {
            return response()->json(['message' => 'У вас уже есть зарезервированная книга!', 'status' => 'error']);
        }
        (new NotificationsService())->createNotification(
            Auth::id(),
            'Sys',
            'Резервация',
            'Вы резервировали книгу: '. $reserve->book->tittle .', вы можете получить книгу до '. $date
        );
        return response()->json(['redirect' => '/books']);

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
        if(Reserve::where('iduser', $request->get('user'))->exists()) {
            //хз верно это или нет, но не вставлять же абсолютно одинаковую функцию в два контроллера
            $responceIssuance = parent::issuanceBook($request->get('user'), $request->get('book'), true);
            if(key_exists('redirect', $responceIssuance)) {
                Reserve::destroy($request->get('reserve'));
            }
            return response()->json($responceIssuance);

        } else {
            return response()->json(['message' => 'У пользователя нет резервированных книг', 'status' => 'error']);
        }
    }


public function deleteReservation(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        if(Reserve::find($id)->exists()) {
            Reserve::destroy($id);
        } else {
            return response()->json(['message' => 'У пользователя нет резервированных книг', 'status' => 'error']);
        }
        return response()->json(['message' => 'Резервация успешно удалена', 'status' => 'success']);

    }
}
