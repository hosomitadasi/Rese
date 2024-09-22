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

    public function indexAdmin()
    {
        $user = Auth::user();

        return view('admins.index', compact('user'));
    }

    public function indexCreate()
    {
        return view('admins.create');
    }

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
            return redirect()->route('admins.index')->with('result', '新しい代表を登録しました。');
        } catch (\Throwable $e) {
            \Log::error($e);
            return redirect('admins.create')->with('result', 'エラーが発生しました');
        }
    }

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

        return view('admins.shopkeeper', compact('owners'));
    }

    public function deleteOwner($id)
    {
        $owner = User::findOrFail($id);
        $owner->delete();

        return redirect()->route('admins.shopkeeper')->with('status', '店舗代表者を削除しました。');
    }

    public function editOwner($id)
    {
        $owner = User::findOrFail($id);
        return view('admins.editOwner', compact('owner'));
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

        return redirect()->route('admins.shopkeeper')->with('status', '店舗代表者の情報を更新しました。');
    }

    public function indexMail()
    {
        return view('admins.mail');
    }

    public function sendCampaignMail(Request $request)
    {
        $users = User::where('role', 3)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new CampaignMail($request->input('content')));
        }

        return redirect()->back()->with('status', 'キャンペーンメールを送信しました。');
    }

    public function indexAdminMenu()
    {
        return view('menus.admin_menu');
    }
}
