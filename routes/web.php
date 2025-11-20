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

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
 Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
 Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
 Route::get('/dashboard', [DashboardController::class, 'index']);

// Monitoring Report
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

// Support
Route::prefix('support')->name('support.')->group(function () {
    Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');
    Route::get('/faq', [SupportController::class, 'faq'])->name('faq');
});

// Settings
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/general', [SettingsController::class, 'general'])->name('general');
    Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
});

// Accounts
Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::get('/security', [AccountController::class, 'security'])->name('security');
        Route::put('/security', [AccountController::class, 'updatePassword'])->name('security.update');
});

// Master Data
Route::prefix('master')->name('master.')->group(function () {

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

      // companies
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    // industry
    Route::get('/industry', [IndustryController::class, 'index'])->name('industry');
    Route::get('/industry/data', [IndustryController::class, 'getData'])->name('industry.data');
    Route::post('/industry', [IndustryController::class, 'store'])->name('industry.store');
    Route::put('/industry/{id}', [IndustryController::class, 'update'])->name('industry.update');
    Route::delete('/industry/{id}', [IndustryController::class, 'destroy'])->name('industry.destroy');

    // Stacks Routes
    Route::get('/stacks', [StackController::class, 'index'])->name('stacks');
    Route::get('/stacks/data', [StackController::class, 'getData'])->name('stacks.data');
    Route::post('/stacks', [StackController::class, 'store'])->name('stacks.store');
    Route::put('/stacks/{id}', [StackController::class, 'update'])->name('stacks.update');
    Route::delete('/stacks/{id}', [StackController::class, 'destroy'])->name('stacks.destroy');

    // Priority Routes
    Route::get('/priorities', [PriorityController::class, 'index'])->name('priorities');
    Route::get('/priorities/data', [PriorityController::class, 'getData'])->name('priorities.data'); // Ajax
    Route::post('/priorities', [PriorityController::class, 'store'])->name('priorities.store');
    Route::put('/priorities/{id}', [PriorityController::class, 'update'])->name('priorities.update');
    Route::delete('/priorities/{id}', [PriorityController::class, 'destroy'])->name('priorities.destroy');

    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/data', [CategoryController::class, 'getData'])->name('categories.data'); // Ajax Yajra
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/notification-medias', [NotificationMediaController::class, 'index'])->name('notification-medias');
    Route::get('/receiver-notification', [ReceiverNotificationController::class, 'index'])->name('receiver-notification');
    Route::get('/parameter', [ParameterController::class, 'index'])->name('parameter');
});