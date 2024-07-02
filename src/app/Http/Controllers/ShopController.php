<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function indexHome()
    {
        $stores = Store::all();
        return view('home', compact('stores'));
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
        $stores = $query->get();
        return view('home', compact('stores'));
    }

    public function indexDetail($id)
    {
        $shop = Store::findOrFail($id);
        return view('detail', compact('shop'));
    }

    public function additonByStore(Request $request)
    {

        Reservation::create([
            'user_id' => Auth::id(),
            'store_id' => $request->store_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'num_people' => $request->num_people,
        ]);
    }

    public function additonByFavorite(Request $request)
    {
        Favorite::create([
            'user_id' => Auth::id(),
            'store_id' => $request->store_id,
        ]);

        return back();
    }

     public function deleteByFavorite(Request $request)
    {
        Favorite::where('user_id', Auth::id())
                ->where('store_id', $request->store_id)
                ->delete();

        return back();
    }


     public function indexDone()
    {
        return view('done');
    }
}
