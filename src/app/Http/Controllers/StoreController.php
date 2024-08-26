<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Store;
use Carbon\Carbon;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\StorePaymentRequest;
use Exception;

use Ramsey\Uuid\Builder\FallbackBuilder;

class StoreController extends Controller
{
    // 店舗一覧ページ（home.blade.php）表示機能
    public function indexHome()
    {
        $user = Auth::user();
        $stores = Store::with('area', 'genre')->get()->map(function ($store) use ($user) {
            $store->is_Favorite = $user ? $store->checkIfFavorite() : false;
            return $store;
        });

        $areas = Area::all();
        $genres = Genre::all();

        return view('stores.home', compact('stores', 'areas', 'genres'));
    }

    // 飲食店検索機能
    public function search(Request $request)
    {
        $user = Auth::user();
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
        $stores = $query->with('area', 'genre')->get()->map(function ($store) use ($user) {
            $store->is_Favorite = $user ? $store->checkIfFavorite() : false;
            return $store;
        });

        $areas = Area::all();
        $genres = Genre::all();
        return view('stores.home', compact('stores', 'areas', 'genres'));
    }

    // 店舗詳細ページ（detail.blade.php）表示機能
    public function indexDetail($id)
    {
        $shop = Store::findOrFail($id);
        return view('stores.detail', compact('shop'));
    }

    // マイページ（mypage.blade.php）表示機能
    public function indexMypage()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', Auth::id())->where('reservation_date', '>=', now()->format('Y-m-d'))->get();
        $favorites = Favorite::where('user_id', Auth::id())->with('store.area', 'store.genre')->get();

        return view('stores.mypage', compact('user', 'reservations', 'favorites'));
    }

    // レビュー作成機能
    public function review(Request $request)
    {

        $request->validate([
            'shop_id' => 'required|exists:stores,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = new Review();
        $review->store_id = $request->shop_id;
        $review->user_id = Auth::id();
        $review->stars = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('message', 'レビューが投稿されました');
    }

    // お気に入り追加、削除機能
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
            return redirect()->route('done', ['shop' => $request->shop_id]);
        } catch (\Throwable $th) {
            return redirect('detail')->with('result', 'エラーが発生しました');
        }
    }

    // 予約完了ページ（done.blade.php）表示機能
    public function indexDone($shopID)
    {
        $shop = Store::findOrFail($shopID);
        return view('stores.done', compact('shop'));
    }

    // 予約削除機能
    public function cancelReservation(Request $request, $id)
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

    // QRコード作成機能
    public function generateQrCode($reservationID)
    {
        $reservation = Reservation::find($reservationID);

        if (!$reservation) {
            return response('予約が見つかりません', 404);
        }

        $qrDate = json_encode([
            'id' => $reservation->id,
            'name' => $reservation->user->name,
            'date' => $reservation->reservation_date,
            'time' => $reservation->reservation_time,
            'people' => $reservation->num_people
        ]);

        $qrCode = QrCode::size(200)->generate($qrDate);
        return response($qrCode)->header('Content-Type', 'image/png');
    }

    // 決済画面表示
    public function createPayment()
    {
        return view('stores.payment');
    }

    // 決済実行
    public function storePayment(StorePaymentRequest $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => 1000,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        }
        return back()->with('status', '決済が完了しました！');
    }
}
