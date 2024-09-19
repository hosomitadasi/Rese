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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = new User([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' =>2,
            ]);
            $user->save();
            return redirect()->route('admin.index')->with('result', '新しい代表を登録しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            return redirect('admin.create')->with('result', 'エラーが発生しました');
        }
    }

    // 店舗代表者管理ページ表示
    public function indexShopkeeper(Request $request)
    {
        $query = User::where('role', 2);

        if($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $owners = $query->paginate(10);

        return view('admin.shopkeeper', compact('owners'));
    }

    // 店舗代表者削除機能
    public function deleteOwner($id)
    {
        $owner = User::findOrFail($id);
        $owner->delete();

        return redirect()->route('admin.shopkeeper')->with('status', '店舗代表者を削除しました。');
    }

    public function editOwner($id)
    {
        $owner = User::findOrFail($id);
        return view('admin.editOwner', compact('owner'));
    }

    public function updateOwner(Request $request, $id)
    {
        $owner = User::findOrFail($id);
        $owner->name = $request->input('name');
        $owner->email = $request->input('email');
        if ($request->filled('password')) {
            $owner->password = Hash::make($request->input('password'));
        }
        $owner->save();

        return redirect()->route('admin.shopkeeper')->with('status', '店舗代表者の情報を更新しました。');
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
