<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $message = $request->input('message');
        if (!$message) return response()->json(['status' => 'ignored']);

        $chatId = $message['chat']['id'];
        $text = $message['text'] ?? '';

        if ($text === '/start') {
            User::updateOrCreate(
                ['telegram_id' => $chatId],
                ['name' => $message['chat']['first_name'] ?? null, 'subscribed' => true]
            );
            $this->sendMessage($chatId, 'Вы успешно подписаны на уведомления!');
        }

        if ($text === '/stop') {
            User::where('telegram_id', $chatId)->update(['subscribed' => false]);
            $this->sendMessage($chatId, 'Вы отписались от уведомлений.');
        }

        return response()->json(['status' => 'ok']);
    }

    private function sendMessage($chatId, $text)
    {
        $token = config('services.telegram.bot_token');
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => $text,
        ]);
    }
}
