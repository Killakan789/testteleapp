<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('создает пользователя при /start', function () {
    $this->postJson('/api/telegram/webhook', [
        'message' => [
            'chat' => ['id' => '12345', 'first_name' => 'Test'],
            'text' => '/start',
        ],
    ])->assertOk();

    expect(User::where('telegram_id', '12345')->exists())->toBeTrue();
});
