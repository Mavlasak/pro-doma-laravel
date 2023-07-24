<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventController AS AdminEventController;
use App\Http\Controllers\Admin\FileController AS AdminFileController;
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
    Route::get('udalost/{event}','show')->name('event.detail');
});

Route::controller(AdminEventController::class)->group(function() {
    Route::get('admin/udalost','index')->name('admin.event.index');
    Route::get('admin/udalost/nova', 'new')->name('admin.event.new');
    Route::get('admin/udalost/{event}','show')->name('admin.event.detail');
    Route::get('admin/udalost/{event}/editovat','edit')->name('admin.event.edit');
    Route::post('admin/udalost', 'store')->name('admin.event.store');
    Route::put('admin/udalost/{event}','update')->name('admin.event.update');
    Route::delete('admin/udalost/{event}','delete')->name('admin.event.delete');
});

Route::controller(FileController::class)->group(function() {
    Route::get('soubor/{file}/download','download')->name('file.download');
    Route::delete('soubor/{file}/smazat','delete')->name('file.delete');
});

Route::controller(AdminFileController::class)->group(function() {
    Route::delete('soubor/{file}/smazat','delete')->name('admin.file.delete');
});
