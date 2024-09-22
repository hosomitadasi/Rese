<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class OwnerController extends Controller
{
    // 店舗代表者用ホームページ表示
    public function indexOwner(Request $request)
    {
        return view('owners.index');
    }

    // 店舗作成ページ表示
    public function indexCreate()
    {
        return view('owners.create');
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

        return redirect()->route('owners.store')->with('success', '店舗が作成されました');
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
        return view('owners.store', compact('stores'));
    }

    public function deleteStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('owners.store')->with('success', '店舗が削除されました');
    }

    public function editStore($id)
    {
        $store = Store::findOrFail($id);
        return view('owners.edit', compact('store'));
    }

    public function updateStore(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->all());

        return redirect()->route('owners.store')->with('success', '店舗が更新されました');
    }

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
        return view('owners.res', compact('reservations'));
    }

    public function indexOwnerMenu()
    {
        return view('menus.owner_menu');
    }

}
