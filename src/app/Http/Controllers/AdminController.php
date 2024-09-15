<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\CampaignMail;

class AdminController extends Controller
{
    // 管理人ページ表示
    public function indexAdmin()
    {
        $user = Auth::user();

        return view('admin.index', compact('user'));
    }

    // 店舗代表者作成ページ表示
    public function indexCreate()
    {
        return view('admin.create');
    }

    // 店舗代表者作成
    public function createOwner(Request $request)
    {
        try {
            $user = new User([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' =>2,
            ]);
            $user->save();
            return redirect()->route('admin.index');
        } catch (\Throwable $e) {
            \Log::error($e);
            return redirect('admin.create')->with('result', 'エラーが発生しました');
        }
    }

    // 店舗代表者管理ページ表示
    public function indexShopkeeper()
    {
        $user = Auth::user();
        return view('admin.shopkeeper', compact('user'));
    }

    // 店舗代表者削除機能
    public function deleteOwner(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if ($user && $user->id == Auth::id()) {
            $user->delete();
        }
        return redirect()->route('admin.shopkeeper')->with('status', '店舗代表者を削除しました。');
    }

    // 店舗代表者編集ページ表示
    public function indexEdit()
    {
        return view('admin.edit');
    }

    // 店舗代表者編集機能
    public function changeOwner(Request $request, $id)
    {
        $user = User::find($id);
        if ($user && $user->user_id == Auth::id()) {
            $user->user_name = $request->input('name');
            $user->user_email = $request->input('email');
            if ($request->input('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
        }
        return redirect()->route('admin.shopkeeper')->with('status', '店舗代表者の情報を変更しました。');
    }

    // メール送信ページ表示
    public function indexMail()
    {
        return view('admin.mail');
    }

    // メール送信処理
    public function sendCampaignMail(Request $request)
    {
        $users = User::where('role', 3)->get();  // 利用者(role=3)のみを取得

        foreach ($users as $user) {
            Mail::to($user->email)->send(new CampaignMail($request->input('content')));
        }

        return redirect()->back()->with('status', 'キャンペーンメールを送信しました。');
    }

    // 管理人用メニュー表示
    public function indexAdminMenu()
    {
        return view('menu.admin_menu');
    }
}
