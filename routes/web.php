<?php

declare(strict_types=1);

use App\Http\Controllers\GmailOauthController;
use App\Http\Livewire\MainPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function (): void {
    Route::get('/', MainPage::class)->name('home');

    Route::get('/oauth/gmail', [GmailOauthController::class, 'redirect'])->name('gmail.connect');
    Route::get('/oauth/gmail/callback', [GmailOauthController::class, 'callback'])->name('gmail.callback');
    Route::get('/oauth/gmail/logout', [GmailOauthController::class, 'logout'])->name('gmail.disconnect');
});
