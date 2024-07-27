<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Store;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Builder\FallbackBuilder;

class ShopController extends Controller
{
    public function indexHome()
    {
        $stores = Store::with('area', 'genre')->get()->map(function($store) {
            $store->isFavorite = $store->isFavorite();
            return $store;
        });

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
        $currentDateTime = now();
        $reservationDateTime = Carbon::parse($request->reservation_date . ' ' . $request->reservation_time);

        if ($reservationDateTime->lessThanOrEqualTo($currentDateTime)) {
            return redirect()->back()->withErrors(['reservation_time'=> '過去および当日の時間には予約できません。']);
        }

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

    public function toggleFavorite($id)
    {
        $user_id = Auth::id();
        $favorite = Favorite::where('user_id', $user_id)->where('store_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('status', 'お気に入りから削除しました');
        } else {
            Favorite::create([
                'user_id' => $user_id,
                'store_id' => $id,
            ]);
            return back()->with('status', 'お気に入りに追加しました');
        }
    }

    public function indexDone()
    {
        return view('shop/done');
    }
}
