<?php

namespace App\Console\Commands;

use App\Models\Reserve;
use App\Services\NotificationsService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class NotifyReservesDueDate extends Command
{
    protected $signature = 'notify:reserves';
    protected $description = 'Уведомляет пользователей в день конца резервации';

    protected NotificationsService $notificationsService;

    public function __construct(NotificationsService $notificationsService)
    {
        parent::__construct();

        $this->notificationsService = $notificationsService;
    }

    public function handle()
    {
        $notificationDate = Carbon::now()->toDateString();

        $reserves = Reserve::where('date', $notificationDate)->get();

        foreach ($reserves as $reserve) {
            $this->notifyUser($reserve);
        }
    }

    public function notifyUser($reserve)
    {
        $this->notificationsService->createNotification(
            $reserve->iduser,
            'Sys',
            'Резервация',
            'Сегодня кончается резервация книги: ' . $reserve->book->tittle
        );
    }
}
