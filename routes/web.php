<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShortageController;

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



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/go/{link}', [HomeController::class, 'go'])->name('home');
Route::post('/store', [ShortageController::class, 'store'])->name('store');
Route::put('/update', [ShortageController::class, 'update'])->name('update');
Route::delete('/delete', [ShortageController::class, 'destroy'])->name('delete');
