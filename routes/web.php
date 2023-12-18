<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'step2'])->name('step2');
Route::post('/step3', [HomeController::class, 'step3'])->name('step3');
Route::post('/review', [HomeController::class, 'review'])->name('review');
Route::post('/order', [HomeController::class, 'order'])->name('order');
