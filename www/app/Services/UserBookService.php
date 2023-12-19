<?php

namespace App\Services;

use App\Models\User;
use App\Models\User_Book;

class UserBookService
{
    public function createUserBook($userId, $bookId, $surrenderId): void
    {
        User_Book::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'surrender_id' => $surrenderId,
            'status' => true,
        ]);
    }

    public function editUserBook($id): void
    {
        $userBook = User_Book::where('surrender_id', $id)->first();
        $userBook->status = false;
        $userBook->save();
    }
}
