<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Books;
use App\Models\Surrender;
use App\Services\NotificationsService;
use App\Services\UserBookService;
use Illuminate\Support\Facades\Auth;

class BookTransactionController extends Controller
{
    protected function issuanceBook($userId, $id, bool $reserved = false): array
    {
        if ((optional(User::find($userId))->unique_key) === Auth::user()->unique_key) {
            if (Surrender::where('iduser', $userId)->count() == 0) {

                $date = now()->addDays(7)->format('Y-m-d');

                if (!$reserved) {
                    $book = Books::find($id);
                    $count = $book->count ?? 0;
                    if ($count > 0) {
                        $book->count = $count - 1;
                        $book->save();
                    } else {
                        return ['message' => 'К сожалению на данный момент книга отсутствует в библиотеке', 'status' => 'warning'];
                    }
                }

                $surrender = Surrender::create([
                    'idbook' => $id,
                    'iduser' => $userId,
                    'date' => $date,
                    'unique_key' => Auth::user()->unique_key
                ]);

                (new UserBookService)->createUserBook($userId, $id, $surrender->id);

            } else {
                return ['message' => 'У пользователя уже есть книга', 'status' => 'error'];
            }
        } else {
            return ['message' => 'Пользователь с таким id не найден в вашей библиотеке', 'status' => 'error'];
        }
        (new NotificationsService())->createNotification(
            $userId,
            'Sys',
            'Выдача книги',
            'Вам выдали книгу: ' . $surrender->book->tittle . ', вы должны сдать книгу до ' . $date
        );
        return ['redirect' => '/books'];
    }
}
