<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpamDetectionController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
Route::get('/emails/create', [EmailController::class, 'create'])->name('emails.create');
Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
Route::get('emails/sent', [EmailController::class, 'sent'])->name('emails.sent');
Route::get('emails/spam', [EmailController::class, 'spam'])->name('emails.spam');
Route::get('emails/trash', [EmailController::class, 'trash'])->name('emails.trash');
Route::delete('emails/{id}', [EmailController::class, 'softDelete'])->name('emails.softDelete');
Route::patch('emails/{id}/restore', [EmailController::class, 'restore'])->name('emails.restore');
Route::get('emails/{email}', [EmailController::class, 'show'])->name('emails.show');

// Profile Routes
Route::put('/update-profile', [ProfileController::class, 'update'])->name('update-profile');

// Spam Detection
Route::post('/check-spam', [SpamDetectionController::class, 'checkSpam'])->name('check-spam');
