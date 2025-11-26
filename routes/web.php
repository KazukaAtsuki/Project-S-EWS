<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\NotificationMediaController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ReceiverNotificationController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TicketController;

use Illuminate\Support\Facades\Http;



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['role:Admin,NOC,CEMS Operator'])->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Halaman Utama
        Route::get('/monitoring-report', [MonitoringController::class, 'index'])->name('monitoring.index');

        // API Data untuk Tabel & Chart (Dipanggil via AJAX)
        Route::get('/monitoring/data', [MonitoringController::class, 'getData'])->name('monitoring.data');
        Route::get('/monitoring/chart', [MonitoringController::class, 'getChartData'])->name('monitoring.chart');

        // Support (Tickets & FAQ)
        Route::prefix('support')->name('support.')->group(function () {

            // List Ticket (Table)
            Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
            Route::get('/tickets/data', [TicketController::class, 'getData'])->name('tickets.data');

            // Create Ticket (Form)
            Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
            Route::post('/ticket/store', [TicketController::class, 'store'])->name('tickets.store');
            Route::get('/ticket/{id}/show', [TicketController::class, 'show'])->name('tickets.show');

            // Delete
            Route::delete('/ticket/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
        });

         // Settings (General & Notification)
         Route::prefix('settings')->name('settings.')->group(function () {
            // General Settings
            Route::get('/general', [SettingsController::class, 'general'])->name('general');
            Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');

            // Notification Settings
            Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
            Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        });

        // Accounts (Profile & Security)
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
            Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
            Route::get('/security', [AccountController::class, 'security'])->name('security');
            Route::put('/security', [AccountController::class, 'updatePassword'])->name('security.update');
        });
    });

    // ====================================================
    // GROUP: KHUSUS ADMIN (Master Data)
    // Hanya Admin yang boleh utak-atik data master
    // ====================================================
    Route::middleware(['role:Admin'])->prefix('master')->name('master.')->group(function () {

        // User Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users');
        Route::get('/users/data', [UserManagementController::class, 'getData'])->name('users.data');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.delete');
        Route::post('/users/{id}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle');
        Route::get('/generate-password', [UserManagementController::class, 'generatePassword'])->name('users.generate-password');

        // Levels
        Route::get('/levels', [LevelController::class, 'levels'])->name('levels');
        Route::get('/levels/data', [LevelController::class, 'getData'])->name('levels.data');
        Route::get('/levels/create', [LevelController::class, 'create'])->name('levels.create');
        Route::post('/levels', [LevelController::class, 'store'])->name('levels.store');
        Route::get('/levels/{id}/edit', [LevelController::class, 'edit'])->name('levels.edit');
        Route::put('/levels/{id}', [LevelController::class, 'update'])->name('levels.update');
        Route::delete('/levels/{id}', [LevelController::class, 'destroy'])->name('levels.delete');

        // Companies
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
        Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
        Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

        // Industry
        Route::get('/industry', [IndustryController::class, 'index'])->name('industry');
        Route::get('/industry/data', [IndustryController::class, 'getData'])->name('industry.data');
        Route::post('/industry', [IndustryController::class, 'store'])->name('industry.store');
        Route::put('/industry/{id}', [IndustryController::class, 'update'])->name('industry.update');
        Route::delete('/industry/{id}', [IndustryController::class, 'destroy'])->name('industry.destroy');

        // Stacks
        Route::get('/stacks', [StackController::class, 'index'])->name('stacks');
        Route::get('/stacks/data', [StackController::class, 'getData'])->name('stacks.data');
        Route::post('/stacks', [StackController::class, 'store'])->name('stacks.store');
        Route::put('/stacks/{id}', [StackController::class, 'update'])->name('stacks.update');
        Route::delete('/stacks/{id}', [StackController::class, 'destroy'])->name('stacks.destroy');

        // Priorities
        Route::get('/priorities', [PriorityController::class, 'index'])->name('priorities');
        Route::get('/priorities/data', [PriorityController::class, 'getData'])->name('priorities.data');
        Route::post('/priorities', [PriorityController::class, 'store'])->name('priorities.store');
        Route::put('/priorities/{id}', [PriorityController::class, 'update'])->name('priorities.update');
        Route::delete('/priorities/{id}', [PriorityController::class, 'destroy'])->name('priorities.destroy');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('/categories/data', [CategoryController::class, 'getData'])->name('categories.data');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

       // Notification Medias Routes
       Route::get('/notification-medias', [NotificationMediaController::class, 'index'])->name('notification-medias');
       Route::get('/notification-medias/data', [NotificationMediaController::class, 'getData'])->name('notification-medias.data');
       Route::post('/notification-medias', [NotificationMediaController::class, 'store'])->name('notification-medias.store');
       Route::put('/notification-medias/{id}', [NotificationMediaController::class, 'update'])->name('notification-medias.update');
       Route::delete('/notification-medias/{id}', [NotificationMediaController::class, 'destroy'])->name('notification-medias.destroy');


        // Receiver Notification Routes
        Route::get('/receiver-notification', [ReceiverNotificationController::class, 'index'])->name('receiver-notification');
        Route::get('/receiver-notification/data', [ReceiverNotificationController::class, 'getData'])->name('receiver-notification.data');
        Route::post('/receiver-notification', [ReceiverNotificationController::class, 'store'])->name('receiver-notification.store');
        Route::put('/receiver-notification/{id}', [ReceiverNotificationController::class, 'update'])->name('receiver-notification.update');
        Route::delete('/receiver-notification/{id}', [ReceiverNotificationController::class, 'destroy'])->name('receiver-notification.destroy');

        // Parameter Routes
        Route::get('/parameter', [ParameterController::class, 'index'])->name('parameter');
        Route::get('/parameter/data', [ParameterController::class, 'getData'])->name('parameter.data'); // Ajax
        Route::post('/parameter', [ParameterController::class, 'store'])->name('parameter.store');
        Route::put('/parameter/{id}', [ParameterController::class, 'update'])->name('parameter.update');
        Route::delete('/parameter/{id}', [ParameterController::class, 'destroy'])->name('parameter.destroy');

    });



    // --- ROUTE TES TELEGRAM ---
    Route::get('/kirim-telegram', function () {
        $token = env('TELEGRAM_BOT_TOKEN');

        // --- TAMBAHAN UNTUK CEK ---
        if (empty($token)) {
            return "GAWAT! Token kosong. Pastikan .env sudah di-save dan server di-restart.";
        }
        // Tampilkan token di layar sebentar untuk memastikan sama dengan BotFather
        // (Hapus baris ini nanti kalau sudah fix)
        echo "Token yang dibaca Laravel: " . $token . "<br><br>";
        // ---------------------------

        $chat_id = env('TELEGRAM_CHAT_ID');

        $response = \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chat_id,
            'text' => "Halo, ini tes ulang!",
        ]);

        return $response->json();
    });

});