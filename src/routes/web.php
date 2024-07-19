<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;

// 既存のルート
Route::get('/home', [ShopController::class, 'indexHome'])->name('home');
Route::get('search', [ShopController::class, 'search'])->name('search');
Route::get('detail/{id}', [ShopController::class, 'indexDetail'])->name('detail');

// 認証ルート
Route::get('views/register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('views/register', [AuthController::class, 'createRegister']);
Route::get('thanks', [AuthController::class, 'indexThanks'])->name('thanks');
Route::get('views/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('views/login', [AuthController::class, 'postLogin']);

Route::get('email/verify', [AuthController::class, 'showVerifyNotice'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify')->middleware(['signed']);
Route::post('email/resend', [AuthController::class, 'resendVerificationEmail'])->name('verification.resend')->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('mypage', [MypageController::class, 'indexMypage'])->name('mypage');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('reserve', [ShopController::class, 'addReservation'])->name('reserve');
    Route::delete('mypage/cancel/{id}', [MypageController::class, 'cancelReservation'])->name('reserve.cancel');
    Route::post('favorite/{id}', [ShopController::class, 'addFavorite'])->name('favorite.add');
    Route::delete('favorite/{id}', [ShopController::class, 'deleteFavorite'])->name('favorite.delete');
    Route::get('done', [ShopController::class, 'indexDone'])->name('done');
    Route::get('menu1', [AuthController::class, 'indexMenu1'])->name('menu1');
});

Route::get('menu2', [AuthController::class, 'indexMenu2'])->name('menu2');

