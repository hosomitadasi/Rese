<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // 会員登録ページ（register.blade.php）表示機能
    public function indexRegister()
    {
        return view('auth.register');
    }

    // 会員登録機能
    public function  createRegister(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('verification.notice');
        } catch (\Throwable $th) {
            return redirect('register')->with('result', 'エラーが発生しました');
        }
    }

    // 登録完了ページ（thanks.blade.php）表示機能
    public function indexThanks()
    {
        return view('auth.thanks');
    }

    // ログインページ（login.blade.php）表示機能
    public function indexLogin()
    {
        return view('auth.login');
    }

    // ログイン処理機能
    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect('/mypage');
        } else {
            return redirect('login')->with('result', 'メールアドレスまたはパスワードが間違っております');
        }
    }

    // ログアウト機能
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    // ログイン後メニューページ（home_menu1.blade.php）表示機能
    public function indexHomeMenu()
    {
        return view('menu.home_menu');
    }

     // ログイン前メニューページ（auth_menu.blade.php）表示機能
    public function indexAuthMenu()
    {
        return view('menu.auth_menu');
    }

}
