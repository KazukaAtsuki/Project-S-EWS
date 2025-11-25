<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test-api', function () {
    return response()->json(['message' => 'API OK']);
});

// Telegram API Routes
Route::prefix('telegram')->group(function () {
    // Send simple message
    Route::post('/send-message', [TelegramController::class, 'sendMessage']);
    
    // Send alert notification
    Route::post('/send-alert', [TelegramController::class, 'sendAlert']);
    
    // Get bot information
    Route::get('/bot-info', [TelegramController::class, 'getBotInfo']);
    
    // Test parameter drop simulation
    Route::post('/test-parameter-drop', [TelegramController::class, 'testParameterDrop']);
    Route::post('/webhook', [TelegramController::class, 'webhook']);
});
