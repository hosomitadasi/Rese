<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Reservation;

class MypageController extends Controller
{
    public function indexMypage()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', Auth::id())->get();
        $favorites = Favorite::where('user_id', Auth::id())->get();

        return view('mypage', compact('user', 'reservations', 'favorites'));
    }

    public function cancelReservation(Request $request ,$id)
    {
        $reservation = Reservation::find($id);
        if ($reservation && $reservation->user_id == Auth::id()) {
            $reservation->delete();
        }
        return redirect()->route('mypage')->with('status', '予約をキャンセルしました。');
    }
}
