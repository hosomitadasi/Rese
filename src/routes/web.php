<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\MypageController;

// 飲食店ルート
Route::get('home', [ShopController::class, 'indexHome'])->name('home');
Route::get('search', [ShopController::class, 'search'])->name('search');
Route::get('detail/{id}', [ShopController::class, 'indexDetail'])->name('detail');

// 認証ルート
Route::get('/register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('/register', [AuthController::class, 'createRegister']);
Route::get('/thanks', [AuthController::class, 'indexThanks'])->name('thanks');
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);

// ログイン後処理ルート
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'indexMypage'])->name('mypage');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('reserve', [MypageController::class, 'addReservation'])->name('reserve');
    Route::delete('mypage/cancel/{id}', [MypageController::class, 'cancelReservation'])->name('reserve.cancel');
    Route::post('mypage/change/{id}', [MypageController::class, 'changeReservation'])->name('reserve.change');

    Route::post('favorite/toggle/{id}', [ShopController::class, 'toggleFavorite'])->name('favorite.toggle');

    Route::get('done', [ShopController::class, 'indexDone'])->name('done');
    Route::get('menu/menu1', [AuthController::class, 'indexMenu1'])->name('menu1');

    Route::post('detail/{id}', [ShopController::class, 'review']);
});

Route::get('menu/menu2', [AuthController::class, 'indexMenu2'])->name('menu2');

// 管理者ページルート
Route::middleware(['role:admin'])->group(function() {
    Route::get('/admin', [AdminController::class, 'indexAdmin'])->name('admin');
    Route::post('/admin/owner', [AdminController::class, 'createStoreOwner'])->name('admin.createStoreOwner');
});

// 店舗代表者ページルート
Route::middleware(['role:store_owner'])->group(function () {
    Route::get('/owner', [StoreController::class, 'indexOwner'])->name('owner');
    Route::resource('stores', StoreController::class);
    Route::get('stores/{store}/reservations', [StoreController::class, 'reservations'])->name('stores.reservations');
});