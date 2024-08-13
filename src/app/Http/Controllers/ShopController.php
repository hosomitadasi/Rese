<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Builder\FallbackBuilder;

class ShopController extends Controller
{
    // 店舗一覧ページ（home.blade.php）表示機能
    public function indexHome()
    {
        $user = Auth::user();
        $stores = Store::with('area', 'genre')->get()->map(function($store) use ($user) {
            $store->is_Favorite = $user ? $store->checkIfFavorite() : false;
            return $store;
        });

        $areas = Area::all();
        $genres = Genre::all();

        return view('home', compact('stores', 'areas', 'genres'));
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
        $stores = $query->with('area', 'genre')->get()->map(function($store) use ($user) {
            $store->is_Favorite = $user ? $store->checkIfFavorite() : false;
            return $store;
        });

        $areas = Area::all();
        $genres = Genre::all();
        return view('home', compact('stores', 'areas', 'genres'));
    }

    // 店舗詳細ページ（detail.blade.php）表示機能
    public function indexDetail($id)
    {
        $shop = Store::findOrFail($id);
        return view('detail', compact('shop'));
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

    // 予約完了ページ（done.blade.php）表示機能
    public function indexDone($shopID)
    {
        $shop = Store::findOrFail($shopID);
        return view('done', compact('shop'));
    }

}
