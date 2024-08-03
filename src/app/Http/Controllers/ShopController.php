<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
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

        $result = false;

        // バリデーション
        $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
                function ($attribute, $value, $fail) use ($request) {

                    // ログインしてるかチェック
                    if (!auth()->check()) {

                        $fail('レビューするにはログインしてください。');
                        return;
                    }

                    // すでにレビュー投稿してるかチェック
                    $exists = \App\ProductReview::where('user_id', $request->user()->id)
                        ->where('product_id', $request->product_id)
                        ->exists();

                    if ($exists) {

                        $fail('すでにレビューは投稿済みです。');
                        return;
                    }
                }
            ],
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $review = new \App\ProductReview();
        $review->product_id = $request->product_id;
        $review->user_id = $request->user()->id;
        $review->stars = $request->stars;
        $review->comment = $request->comment;
        $result = $review->save();
        return ['result' => $result];
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
    public function indexDone()
    {
        return view('shop/done');
    }

}
