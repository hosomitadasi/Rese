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
            $user = new User([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' => 3,
            ]);

            event(new Registered($user));

            $user->save();

            Auth::login($user);

            return redirect()->route('verification.notice');
        } catch (\Throwable $th) {
            \Log::error($th);
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
            $user = Auth::user();

            // ユーザーの役割に応じてリダイレクト先を変更
            if ($user->role == 1) {
                return redirect()->route('admin.index'); // 管理者用ページへ
            } elseif ($user->role == 2) {
                return redirect()->route('owner.index'); // 店舗代表者ページへ
            } else {
                return redirect('/mypage'); // 利用者ページへ
            }
        } else {
            return redirect('login')->with('result', 'メールアドレスまたはパスワードが間違ってます。');
        }
    }

    // ログアウト機能
    public function logout()
    {
        Auth::logout();
        session()->flush();
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
