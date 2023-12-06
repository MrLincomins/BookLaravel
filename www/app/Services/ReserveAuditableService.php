<?php

namespace App\Services;

use App\Models\Books;
use App\Models\User;

class ReserveAuditableService
{
    static function createdFormat(array $data): string
    {
        $bookName = Books::where('id', $data['idbook'])->value('tittle');
        $userName = User::where('id', $data['iduser'])->value('name');

        return "Резервация книги: '{$bookName}' => '{$userName}'";
    }
}
