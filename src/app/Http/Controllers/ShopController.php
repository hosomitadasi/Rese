<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Store;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function indexHome()
    {
        $stores = Store::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        $user = Auth::user();
        foreach ($stores as $store) {
            $store->isFavorite = $user ? $user->favorites->contains('store_id', $store->id) : false;
        }
        return view('home', compact('stores', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        $query = Store::query();
        if ($request->area) {
            $query->where('area_id', $request->area);
        }
        if ($request->genre) {
            $query->where('genre_id', $request->genre);
        }
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $stores = $query->with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('home', compact('stores', 'areas', 'genres'));
    }

    public function indexDetail($id)
    {
        $shop = Store::findOrFail($id);
        return view('detail', compact('shop'));
    }

    public function addReservation(ReservationRequest $request)
    {
        try {
            Reservation::create([
                'user_id' => Auth::id(),
                'store_id' => $request->shop_id,
                'reservation_date' => $request->reservation_date,
                'reservation_time' => $request->reservation_time,
                'num_people' => $request->num_people,
            ]);
            return redirect('done');
        } catch (\Throwable $th) {
            return redirect('detail')->with('result', 'エラーが発生しました');
        }
    }

    public function addFavorite(Request $request, $id)
    {
        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'store_id' => $id,
        ]);

        return back()->with('status', 'お気に入りに追加しました');
    }

     public function deleteFavorite(Request $request, $id)
    {
        Favorite::where('user_id', Auth::id())
            ->where('store_id', $id)
            ->delete();

        return back()->with('status', 'お気に入りから削除しました');
    }


     public function indexDone()
    {
        return view('done');
    }
}
