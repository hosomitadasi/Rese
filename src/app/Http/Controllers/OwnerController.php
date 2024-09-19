<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'overview' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos');
            $photoName = basename($photoPath);
        }

        Store::create([
            'name' => $request->input('name'),
            'area_id' => $request->input('area_id'),
            'genre_id' => $request->input('genre_id'),
            'overview' => $request->input('overview'),
            'photo' => $photoName,
        ]);

        return redirect()->route('owner.store')->with('success', '店舗が作成されました');
    }


    // 店舗管理ページ表示
    public function indexStore(Request $request)
    {
        $stores = Store::query();

        if ($request->has('search')) {
            $stores->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('area', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('genre', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
        }

        $stores = $stores->paginate(10);
        return view('owner.store', compact('stores'));
    }

    // 店舗削除機能
    public function deleteStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('owner.store')->with('success', '店舗が削除されました');
    }

    // 店舗編集機能
    public function editStore($id)
    {
        $store = Store::findOrFail($id);
        return view('owner.edit', compact('store'));
    }

    public function updateStore(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->all());

        return redirect()->route('owner.store')->with('success', '店舗が更新されました');
    }


    // 予約情報表示ページ
    public function indexReservation(Request $request)
    {
        $reservations = Reservation::with('store');

        if ($request->has('search')) {
            $reservations->where('reservation_date', 'like', '%' . $request->search . '%')
            ->orWhereHas('store', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $reservations = $reservations->paginate(10);
        return view('owner.res', compact('reservations'));
    }

    // 管理人用メニュー表示
    public function indexOwnerMenu()
    {
        return view('menu.owner_menu');
    }

}
