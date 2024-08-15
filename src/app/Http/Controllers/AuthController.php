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

            return redirect('thanks');
        } catch (\Throwable $th) {
            return redirect('auth.register')->with('result', 'エラーが発生しました');
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

        return redirect('home');
    }

    // メニュー１ページ（menu1.blade.php）表示機能
    public function indexMenu1()
    {
        return view('menu.menu1');
    }

     // メニュー２ページ（menu2.blade.php）表示機能
    public function indexMenu2()
    {
        return view('menu.menu2');
    }

    // パスワードリセットリンク送信機能
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }

}
