<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // 店舗代表者用ホームページ表示
    public function indexOwner()
    {
        return view('owner.index');
    }

    // 店舗作成ページ表示
    public function indexCreate()
    {
        return view('owner.create');
    }

    // 店舗作成
    public function createStore(Request $request)
    {
        try {
            $store = new Store([
                'name' => $request['name'],
                ''
            ]);
            $store->save();
            return redirect()->route('owner.index');
        } catch (\Throwable $e) {
            \Log::error($e);
            return redirect('owner.create')->with('result', 'エラーが発生しました');
        }
    }

    // 店舗管理ページ表示
    public function indexStore()
    {
        $user = Auth::user();
        $stores = Store::with('area', 'genre')->get()->map(function ($store) use ($user) {
            $store->is_Favorite = $user ? $store->checkIfFavorite() : false;
            return $store;
        });

        $areas = Area::all();
        $genres = Genre::all();

        return view('stores.home', compact('stores', 'areas', 'genres'));
    }

    // 店舗削除機能
    public function deleteStore(Request $request)
    {
        $store = Store::find($request->input('store_id'));
        if ($store && $store->store_id == Auth::id()) {
            $store->delete();
        }
        return redirect()->route('owner.store')->with('status', '店舗代表者を削除しました。');
    }

    // 店舗編集ページ表示
    public function indexEdit()
    {
        return view('owner.edit');
    }

    // 店舗代表者編集機能
    public function changeStore(Request $request, $id)
    {
        $store = Store::find($id);
        if ($store && $store->store_id == Auth::id()) {
        }
        return redirect()->route('owner.store')->with('status', '店舗代表者の情報を変更しました。');
    }

    // メール送信ページ表示
    public function indexReservation()
    {
        return view('owner.res');
    }

    // 管理人用メニュー表示
    public function indexAdminMenu()
    {
        return view('menu.owner_menu');
    }
}
