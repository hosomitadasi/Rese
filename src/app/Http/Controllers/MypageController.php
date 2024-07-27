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
        $reservations = Reservation::where('user_id', Auth::id())->where('reservation_date', '>=', now()->format('Y-m-d'))->get();
        $favorites = Favorite::where('user_id', Auth::id())->with('store.area', 'store.genre')->get();

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

    public function changeReservation(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if ($reservation && $reservation->user_id == Auth::id()) {
            // フォームからの新しいデータを取得し、予約を更新します
            $reservation->reservation_date = $request->input('reservation_date');
            $reservation->reservation_time = $request->input('reservation_time');
            $reservation->num_people = $request->input('num_people');
            $reservation->save();
        }
        return redirect()->route('mypage')->with('status', '予約を変更しました。');
    }
}
