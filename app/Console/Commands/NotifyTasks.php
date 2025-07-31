<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\TasksService;
use App\Jobs\SendTelegramNotification;

class NotifyTasks extends Command
{
    protected $signature = 'notify:tasks';
    protected $description = 'Send Telegram notifications about pending tasks';

    public function handle(TasksService $tasksService)
    {
        $tasks = $tasksService->getTasks();

        if (empty($tasks)) {
            $this->info('Нет невыполненных задач.');
            return;
        }

        $message = "Список невыполненных задач:\n";
        foreach ($tasks as $task) {
            $message .= "- {$task['title']}\n";
        }

        User::where('subscribed', true)->chunk(50, function ($users) use ($message) {
            foreach ($users as $user) {
                SendTelegramNotification::dispatch($user->telegram_id, $message);
            }
        });

        $this->info('Задачи отправлены в очередь.');
    }
}
