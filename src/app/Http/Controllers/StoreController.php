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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('images'), $imageName);

        Store::create([
            'name' => $validated['name'],
            'photo' => $imageName,
            'owner_id' => auth()->id(),
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
