<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;


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

Route::get('/home', [ShopController::class, 'indexHome'])->name('home');
Route::get('search', [ShopController::class, 'search'])->name('search');
Route::get('detail/{id}', [ShopController::class, 'indexDetail'])->name('detail');

Route::get('register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('register', [AuthController::class, 'createRegister']);
Route::get('thanks', [AuthController::class, 'indexThanks'])->name('thanks');

Route::get('login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

Route::middleware('auth')->group(function () {
    Route::get('mypage', [MypageController::class, 'indexMypage'])->name('mypage');

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('reserve/{id}', [ShopController::class, 'addReservation']);
    Route::delete('reservation/{id}', [MypageController::class, 'deleteReservation'])->name('deleteReservation');

    Route::post('favorite/{id}', [ShopController::class, 'addFavorite']);
    Route::delete('favorite/{id}', [ShopController::class, 'deleteFavorite']);
    Route::get('done', [ShopController::class, 'indexDone'])->name('done');
    Route::get('menu1', [AuthController::class, 'indexMenu1'])->name('menu1');
});

Route::get('menu2', [AuthController::class, 'indexMenu2'])->name('menu2');