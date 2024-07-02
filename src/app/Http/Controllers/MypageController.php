<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Reservation;

class MypageController extends Controller
{
    public function indexMypage()
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();
        $favorites = Favorite::where('user_id', Auth::id())->get();

        return view('mypage', compact('reservations', 'favorites'));
    }

    public function deleteByStore(Request $request)
    {

        Reservation::where('id', $request->reservation_id)
                    ->where('user_id', Auth::id())
                    ->delete();

        return back();
    }
}