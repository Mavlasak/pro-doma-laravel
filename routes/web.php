<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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

Route::get('udalost', [EventController::class, 'index'])->name('event.index');
Route::get('udalost/nova', [EventController::class, 'new'])->name('event.new');
Route::get('udalost/{event}', [EventController::class, 'show'])->name('event.detail');
Route::get('udalost/{event}/editovat', [EventController::class, 'edit'])->name('event.edit');
Route::post('udalost', [EventController::class, 'store'])->name('event.store');
Route::put('udalost/{event}', [EventController::class, 'update'])->name('event.update');
Route::delete('udalost/{event}', [EventController::class, 'delete']);
