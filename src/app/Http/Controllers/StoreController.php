<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function indexOwner()
    {
        return view('store_owner.index');
    }

    public function indexStores()
    {
        $stores = Store::where('owner_id', auth()->id())->get();
        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        return view('stores.create');
    }

    // 店舗情報作成処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|integer',
            'genre_id' => 'required|integer',
            'overview' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 画像をストレージに保存
        $path = $request->file('photo')->store('public/photos');

        // データベースに保存
        Store::create([
            'name' => $request->input('name'),
            'area_id' => $request->input('area_id'),
            'genre_id' => $request->input('genre_id'),
            'overview' => $request->input('overview'),
            'photo' => basename($path), // 画像のファイル名のみを保存
        ]);

        return redirect()->route('stores.index')->with('success', '店舗情報を作成しました');
    }

    public function edit(Store $store)
    {
        $this->authorize('update', $store);
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $this->authorize('update', $store);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);
            $store->photo = $imageName;
        }

        $store->name = $validated['name'];
        $store->save();

        return redirect()->route('stores.index')->with('success', '店舗情報を更新しました');
    }

    public function reservations(Store $store)
    {
        $this->authorize('view', $store);
        $reservations = $store->reservations;
        return view('stores.reservations', compact('reservations'));
    }
}
