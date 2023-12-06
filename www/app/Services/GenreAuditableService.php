<?php

namespace App\Services;

class GenreAuditableService
{
    static function createdFormat(array $data): string
    {
        return "Название созданного жанра: {$data['genre']}";
    }
}
