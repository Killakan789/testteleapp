<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TasksService
{
    public function getTasks(): array
    {
        return collect(Http::get('https://jsonplaceholder.typicode.com/todos')->json())
            ->where('completed', false)
            ->where('userId', '<=', 5)
            ->toArray();
    }
}
