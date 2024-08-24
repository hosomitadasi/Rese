<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\MypageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// 飲食店一覧表示ルート
Route::get('/', [ShopController::class, 'indexHome'])->name('home');

// 検索機能処理ルート
Route::get('search', [ShopController::class, 'search'])->name('search');

// 飲食店詳細ページ表示ルート
Route::get('/detail/{id}', [ShopController::class, 'indexDetail'])->name('detail');

// 認証ルート
Route::get('register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('register', [AuthController::class, 'createRegister']);

Route::get('thanks', [AuthController::class, 'indexThanks'])->name('thanks');

Route::get('login', [AuthController::class, 'indexLogin'])->name('login');

Route::post('login', [AuthController::class, 'postLogin']);

// メール確認用ルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// ログイン後処理ルート
Route::middleware('auth')->group(function () {
    // マイページ表示処理ルート
    Route::get('/mypage', [MypageController::class, 'indexMypage'])->name('mypage');

    // ログアウト処理ルート
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 予約処理ルート
    Route::post('reserve', [MypageController::class, 'addReservation'])->name('reserve');

    // 予約削除処理ルート
    Route::delete('mypage/cancel/{id}', [MypageController::class, 'cancelReservation'])->name('reserve.cancel');

    // 予約変更処理ルート
    Route::post('mypage/change/{id}', [MypageController::class, 'changeReservation'])->name('reserve.change');

    // お気に入り処理ルート
    Route::post('favorite/toggle/{id}', [ShopController::class, 'toggleFavorite'])->name('favorite.toggle');

    // 予約完了ページ表示処理ルート
    Route::get('done/{shop}', [ShopController::class, 'indexDone'])->name('done');

    Route::get('menu/menu1', [AuthController::class, 'indexMenu1'])->name('menu1');

    // レビュー作成処理ルート
    Route::post('/reviews', [ShopController::class, 'review'])->name('reviews.store');

    // QRコード作成処理ルート
    Route::get('QrCode/{reservationID}', [MypageController::class, 'generateQrCode'])->name('generate.qr');

    // 決済機能処理ルート
    Route::get('payment', [MypageController::class, 'createPayment'])->name('payment');
    Route::post('/store', [MypageController::class, 'storePayment'])->name('store');
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