<?php

namespace App\Services;

class UserAuditableService
{
    static function changedFormat(array $oldData, array $newData): string
    {
        return "Изменение роли: '{$oldData['role']}' => '{$newData['role']}'";
    }
}
