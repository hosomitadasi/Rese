<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// 飲食店一覧表示ルート
Route::get('/', [StoreController::class, 'indexHome'])->name('home');

// 検索機能処理ルート
Route::get('search', [StoreController::class, 'search'])->name('search');

// 飲食店詳細ページ表示ルート
Route::get('/detail/{id}', [StoreController::class, 'indexDetail'])->name('detail');

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
    Route::get('/mypage', [StoreController::class, 'indexMypage'])->name('mypage');

    // ログアウト処理ルート
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 予約処理ルート
    Route::post('reserve', [StoreController::class, 'addReservation'])->name('reserve');

    // 予約削除処理ルート
    Route::delete('mypage/cancel/{id}', [StoreController::class, 'cancelReservation'])->name('reserve.cancel');

    // 予約変更処理ルート
    Route::post('mypage/change/{id}', [StoreController::class, 'changeReservation'])->name('reserve.change');

    // お気に入り処理ルート
    Route::post('favorite/toggle/{id}', [StoreController::class, 'toggleFavorite'])->name('favorite.toggle');

    // 予約完了ページ表示処理ルート
    Route::get('done/{shop}', [StoreController::class, 'indexDone'])->name('done');

    Route::get('menu/home_menu', [AuthController::class, 'indexHomeMenu'])->name('home_menu');

    // レビュー作成処理ルート
    Route::post('/reviews', [StoreController::class, 'review'])->name('reviews.store');

    // QRコード作成処理ルート
    Route::get('QrCode/{reservationID}', [StoreController::class, 'generateQrCode'])->name('generate.qr');

    // 決済機能処理ルート
    Route::get('payment', [StoreController::class, 'createPayment'])->name('payment');
    Route::post('/store', [StoreController::class, 'storePayment'])->name('store');
});


Route::get('menu/auth_menu', [AuthController::class, 'indexAuthMenu'])->name('auth_menu');

// 管理人用ルート

Route::get('menu/menu3', [AdminController::class, 'indexMenu3'])->name('menu3');

// 店舗代表者用ルート
Route::get('menu/menu4', [AdminController::class, 'indexMenu4'])->name('menu4');