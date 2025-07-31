# Telegram Notify Service

A service for sending tasks from an external API to Telegram using Laravel Queue.

## 🚀 Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan queue:table
php artisan migrate

```

## ⚡ run locally
```bash
php artisan serve
php artisan queue:work
```

## 🤖 Telegram
1. create bot in  @BotFather an get a token.
2. add to  `.env` :
```
TELEGRAM_BOT_TOKEN=<your_token>
```
3. install webhook:
```bash
curl -F "url=https://<your-domain>/api/telegram/webhook" \
     https://api.telegram.org/bot<your_token>/setWebhook
```

4. send to bot `/start`, to subscribe.

## 📤 notifications
```bash
php artisan notify:tasks
```
messages should be in queue
# testteleapp
