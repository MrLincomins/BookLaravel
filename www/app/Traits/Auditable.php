<?php

namespace App\Traits;

use App\Models\Audit_Log;
use App\Models\Books;
use App\Models\Genre;
use App\Models\Reserve;
use App\Models\Role;
use App\Models\Surrender;
use App\Models\User;
use App\Services\BookAuditableService;
use App\Services\GenreAuditableService;
use App\Services\ReserveAuditableService;
use App\Services\RoleAuditableService;
use App\Services\SurrenderAuditableService;
use App\Services\UserAuditableService;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::created(function ($model) {
            if(!$model instanceof User) {
                self::logChanges($model, 'created');
            }
        });

        static::updated(function ($model) {
            if ($model instanceof User && $model->isDirty('role')) {
                self::logChanges($model, 'updated');
            } elseif(!$model instanceof User) {
                self::logChanges($model, 'updated');
            }
        });

        static::deleted(function ($model) {
            if(!$model instanceof User) {
                self::logChanges($model, 'deleted');
            }
        });
    }

    protected static function logChanges($model, $action): void
    {
        $serviceName = self::getServiceName($model);
        $userId = Auth::user()->id;

        $data = match ($action) {
            'created' => $serviceName::createdFormat($model->getAttributes()),
            'updated' => $serviceName::changedFormat($model->getOriginal(),
                $model->getAttributes()),
            default => null,
        };

        Audit_Log::create([
            'user_id' => $userId ?? null,
            'action' => $action,
            'entity_type' => class_basename($model),
            'entity_id' => $model->id,
            'changes_entity' => $data,
            'unique_key' => Auth::user()->unique_key
        ]);
    }

    protected static function getServiceName($model): string
    {
        return match (get_class($model)) {
            Books::class => BookAuditableService::class,
            Role::class => RoleAuditableService::class,
            User::class => UserAuditableService::class,
            Surrender::class => SurrenderAuditableService::class,
            Reserve::class => ReserveAuditableService::class,
            Genre::class => GenreAuditableService::class,
            default => throw new \Exception('Unsupported model type.'),
        };
    }
}

