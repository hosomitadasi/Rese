<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Store;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;

class MypageController extends Controller
{
    // マイページ（mypage.blade.php）表示機能
    public function indexMypage()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', Auth::id())->where('reservation_date', '>=', now()->format('Y-m-d'))->get();
        $favorites = Favorite::where('user_id', Auth::id())->with('store.area', 'store.genre')->get();

        return view('mypage', compact('user', 'reservations', 'favorites'));
    }

    // 予約作成機能
    public function addReservation(ReservationRequest $request)
    {
        $currentDateTime = now();
        $reservationDateTime = Carbon::parse($request->reservation_date . ' ' . $request->reservation_time);

        if ($reservationDateTime->lessThanOrEqualTo($currentDateTime)) {
            return redirect()->back()->withErrors(['reservation_time' => '過去および当日の時間には予約できません。']);
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

    // 予約削除機能
    public function cancelReservation(Request $request ,$id)
    {
        $reservation = Reservation::find($id);
        if ($reservation && $reservation->user_id == Auth::id()) {
            $reservation->delete();
        }
        return redirect()->route('mypage')->with('status', '予約をキャンセルしました。');
    }

    // 予約変更機能
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
