<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function indexRegister()
    {
        return view('register');
    }

    public function  createRegister(RegisterRequest $request)
    {
        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            return redirect('thanks');
        } catch (\Throwable $th) {
            return redirect('register')->with('result', 'エラーが発生しました');
        }
    }

    public function indexThanks()
    {
        return view('thanks');
    }

    public function indexLogin()
    {
        return view('login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect('mypage');
        } else {
            return redirect('login')->with('result', 'メールアドレスまたはパスワードが間違っております');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('home');
    }

      public function indexMenu1()
    {
        return view('menu1');
    }

    public function indexMenu2()
    {
        return view('menu2');
    }
}
