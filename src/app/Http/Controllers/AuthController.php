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
    public function indexRegister()
    {
        return view('auth.register');
    }

    public function  createRegister(RegisterRequest $request)
    {
        try {
            $user = new User([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' => $request['role'],
            ]);
            $user->save();

            event(new Registered($user));

            return redirect()->route('auth.thanks')->with('status', '認証用のメールを送信しました！');
        } catch (\Throwable $th) {
            \Log::error($th);
            return redirect('register')->with('result', 'エラーが発生しました');
        }
    }

    public function indexThanks()
    {
        return view('auth.thanks');
    }

    public function indexLogin()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::user();

            if ($user->role == 1) {
                return redirect()->route('admins.index');
            } elseif ($user->role == 2) {
                return redirect()->route('owners.index');
            } else {
                return redirect('/mypage');
            }
        } else {
            return redirect('login')->with('result', 'メールアドレスまたはパスワードが間違ってます。');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function indexAuthMenu()
    {
        return view('menus.auth_menu');
    }

}
