<?php

namespace App\Services;

class BookAuditableService
{
    static function createdFormat(array $data): string
    {
        $formattedChangesString = '';

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'tittle':
                    $formattedChangesString .= "Название книги: $value, ";
                    break;
                case 'author':
                    $formattedChangesString .= "Автор: $value, ";
                    break;
                case 'year':
                    $formattedChangesString .= "Год: $value, ";
                    break;
                case 'isbn':
                    $formattedChangesString .= "ISBN: $value, ";
                    break;
                case 'genre':
                    $formattedChangesString .= "Жанр: $value, ";
                    break;
                case 'count':
                    $formattedChangesString .= "Кол-во книг: $value, ";
                    break;
            }
        }
        return rtrim($formattedChangesString, ', ');
    }

    static function changedFormat(array $oldData, array $newData): string
    {
        $changedData = [];

        foreach ($oldData as $key => $oldValue) {
            $newValue = $newData[$key] ?? null;

            if ($oldValue !== $newValue) {
                $formattedAttribute = self::formatAttribute($key);
                $changedData[] = [
                    'attribute' => $formattedAttribute,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                ];
            }
        }

        return self::formatChanges($changedData);
    }

    static function formatChanges(array $changes): string
    {
        $formattedChanges = [];

        foreach ($changes as $change) {
            $formattedChanges[] = "{$change['attribute']}: '{$change['old_value']}' => '{$change['new_value']}'";
        }

        return implode(', ', $formattedChanges);
    }

    static function formatAttribute($attribute): string
    {
        return match ($attribute) {
            'tittle' => 'Название книги',
            'author' => 'Автор',
            'year' => 'Год',
            'isbn' => 'ISBN',
            'genre' => 'Жанр',
            'count' => 'Число',
            default => $attribute,
        };
    }
}

