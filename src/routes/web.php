<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\StoreController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// 飲食店一覧表示ルート
Route::get('/', [StoreController::class, 'indexHome'])->name('home');

// 検索機能処理ルート
Route::get('search', [StoreController::class, 'search'])->name('search');

// 飲食店詳細ページ表示ルート
Route::get('/detail/{id}', [StoreController::class, 'indexDetail'])->name('detail');

// ログイン前表示
Route::get('menus/auth_menu', [AuthController::class, 'indexAuthMenu'])->name('auth_menu');

// 認証ルート
Route::get('register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('register', [AuthController::class, 'createRegister']);

Route::get('/thanks', [AuthController::class, 'indexThanks'])->name('auth.thanks');

Route::get('login', [AuthController::class, 'indexLogin'])->name('login');

Route::post('login', [AuthController::class, 'postLogin']);

//メール確認用ルート
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// 利用者用ルート
Route::middleware('auth')->group(function () {
    // マイページ表示処理ルート
    Route::get('/mypage', [StoreController::class, 'indexMypage'])->name('mypage');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

    // レビュー作成処理ルート
    Route::post('/reviews', [StoreController::class, 'review'])->name('reviews.store');

    // QRコード作成処理ルート
    Route::get('QrCode/{reservationID}', [StoreController::class, 'generateQrCode'])->name('generate.qr');

    // 決済機能処理ルート
    Route::get('payment', [StoreController::class, 'createPayment'])->name('payment');
    Route::post('/store', [StoreController::class, 'storePayment'])->name('store');

    // ログイン後メニュー表示
    Route::get('menus/home_menu', [StoreController::class, 'indexHomeMenu'])->name('home_menu');
});

// 管理人用ルート
Route::middleware(['web', 'admin'])->group(function () {
    Route::get('admins/index', [AdminController::class, 'indexAdmin'])->name('admins.index');

    Route::get('admins/create', [AdminController::class, 'indexCreate'])->name('admins.create');
    Route::post('admins/createOwner', [AdminController::class, 'createOwner'])->name('admins.createOwner');

    Route::get('admins/shopkeeper', [AdminController::class, 'indexShopkeeper'])->name('admins.shopkeeper');
    Route::delete('admins/shopkeeper/{id}', [AdminController::class, 'deleteOwner'])->name('admins.deleteOwner');

    Route::get('admins/shopkeeper/edit/{id}', [AdminController::class, 'editOwner'])->name('admins.editOwner');
    Route::post('admins/shopkeeper/edit/{id}', [AdminController::class, 'updateOwner'])->name('admins.updateOwner');


    Route::get('admins/mail', [AdminController::class, 'indexMail'])->name('admins.mail');
    Route::post('admins/send_mail', [AdminController::class, 'sendCampaignMail'])->name('admins.send_mail');

    Route::get('menus/admin_menu', [AdminController::class, 'indexAdminMenu'])->name('admin.menu');
});

// 店舗代表者用ルート
Route::middleware(['web', 'owner'])->group(function () {
    Route::get('owners/index', [OwnerController::class, 'indexOwner'])->name('owners.index');

    Route::get('owners/create', [OwnerController::class, 'indexCreate'])->name('owners.create');
    Route::post('owners/createStore', [OwnerController::class, 'createStore'])->name('owners.createStore');


    Route::get('owners/store', [OwnerController::class, 'indexStore'])->name('owners.store');

    Route::get('owners/res', [OwnerController::class, 'indexReservation'])->name('owners.res');


    Route::get('menus/owner_menu', [OwnerController::class, 'indexOwnerMenu'])->name('owner.menu');
});