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
Route::get('udalost/nova', [EventController::class, 'new']);
Route::get('udalost/{id}', [EventController::class, 'show']);
Route::post('udalost', [EventController::class, 'store'])->name('event.store');
Route::put('udalost/{id}', [EventController::class, 'update']);
Route::delete('udalost/{id}', [EventController::class, 'delete']);
