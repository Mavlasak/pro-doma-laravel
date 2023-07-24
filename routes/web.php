<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;

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

Route::controller(EventController::class)->group(function() {
    Route::get('udalost','index')->name('event.index');
    Route::get('udalost/nova', 'new')->name('event.new');
    Route::get('udalost/{event}','show')->name('event.detail');
    Route::get('udalost/{event}/editovat','edit')->name('event.edit');
    Route::post('udalost', 'store')->name('event.store');
    Route::put('udalost/{event}','update')->name('event.update');
    Route::delete('udalost/{event}','delete')->name('event.delete');
});

Route::controller(FileController::class)->group(function() {
    Route::get('soubor/{file}/download','download')->name('file.download');
});
