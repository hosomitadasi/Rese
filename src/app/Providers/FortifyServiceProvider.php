<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // ログインビューの設定
        Fortify::loginView(function () {
            return view('login'); // 'auth.login' はあなたのログインビューの名前に置き換えてください
        });

        // 登録ビューの設定
        Fortify::registerView(function () {
            return view('register'); // 'auth.register' はあなたの登録ビューの名前に置き換えてください
        });

        // パスワードリセットビューの設定
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password'); // 'auth.forgot-password' はあなたのパスワードリセットリンクリクエストビューの名前に置き換えてください
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]); // 'auth.reset-password' はあなたのパスワードリセットビューの名前に置き換えてください
        });

        // 二要素認証ビューの設定
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge'); // 'auth.two-factor-challenge' はあなたの二要素認証ビューの名前に置き換えてください
        });

    }
}
