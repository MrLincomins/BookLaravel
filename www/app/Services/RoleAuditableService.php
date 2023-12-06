<?php

namespace App\Services;

class RoleAuditableService
{
    protected static array $permissions = [
        1 => 'Изменение книг и жанров',
        2 => 'Удаление книг и жанров',
        4 => 'Создание книг и жанров',
        8 => 'Выдача и возврат книг ученикам',
        16 => 'Просмотр и управление учениками',
    ];

    public static function createdFormat(array $data): string
    {
        $formattedChangesString = '';

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'name':
                    $formattedChangesString .= "Название роли: $value, ";
                    break;
                case 'permissions':
                    $formattedChangesString .= "Права: " . self::formatPermissions($value) . ", ";
                    break;
            }
        }
        return rtrim($formattedChangesString, ', ');
    }

    protected static function formatPermissions($permissions): string
    {
        $formattedPermissions = [];

        foreach (self::$permissions as $key => $permission) {
            if (($permissions & $key) === $key) {
                $formattedPermissions[] = $permission;
            }
        }

        return implode(', ', $formattedPermissions);
    }
    /*
    static function changedFormat(array $data): array
    {
    }
    */
}

