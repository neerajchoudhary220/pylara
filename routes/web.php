<?php

use App\Http\Controllers\SecretNoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SecretNoteController::class)->prefix('notes')->group(function () {
    Route::get('/', 'index')->name('secret.notepad');
    Route::get('/privatenote/{e?}', 'privatelink')->name('secret.notepad.privatelink');
    Route::post('/create', 'create')->name('secret.notepad.create');
    Route::get('view/{notes}', 'view')->name('secret.link');
});
