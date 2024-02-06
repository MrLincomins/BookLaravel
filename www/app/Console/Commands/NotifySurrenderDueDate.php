<?php

namespace App\Console\Commands;

use App\Models\Surrender;
use App\Services\NotificationsService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class NotifySurrenderDueDate extends Command
{
    protected $signature = 'notify:surrender';
    protected $description = 'Уведомляет пользователей за день до даты сдачи';

    protected NotificationsService $notificationsService;

    public function __construct(NotificationsService $notificationsService)
    {
        parent::__construct();

        $this->notificationsService = $notificationsService;
    }

    public function handle()
    {
        $notificationDate = Carbon::now()->addDay();

        $surrenders = Surrender::where('date', $notificationDate->toDateString())->get();

        foreach ($surrenders as $surrender) {
            $this->notifyUser($surrender);
        }
    }

    public function notifyUser($surrender)
    {
        $this->notificationsService->createNotification(
            $surrender->iduser,
            'Sys',
            'Возврат',
            'Завтра вы должны сдать книгу: ' . $surrender->book->tittle
        );
    }
}
