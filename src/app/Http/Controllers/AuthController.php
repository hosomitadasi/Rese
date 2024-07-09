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
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect('thanks');
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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('mypage');
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials.']);
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
