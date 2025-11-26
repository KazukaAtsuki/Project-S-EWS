<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Telegram Bot Token
    |--------------------------------------------------------------------------
    |
    | This is your bot token from BotFather.
    | Keep this secure and never expose it publicly.
    |
    */

    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Telegram Chat ID
    |--------------------------------------------------------------------------
    |
    | Default chat ID for sending notifications.
    | You can override this per notification if needed.
    |
    */

    'chat_id' => env('TELEGRAM_CHAT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Telegram API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for Telegram Bot API.
    |
    */

    'api_url' => 'https://api.telegram.org/bot',

];
