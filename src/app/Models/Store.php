<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'area_id', 'genre_id', 'overview', 'photo'
    ];

    // area.phpとのリレーション
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // genre.phpとのリレーション
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // reservation.phpとのリレーション
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function checkIfFavorite()
    {
        return $this->favorites()->where('user_id', Auth::id())->exists();
    }

    // favorite.phpとのリレーション
    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    // review.phpとのリレーション
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ストレージ内の画像のURLを取得するアクセサ
    public function getPhotoUrlAttribute()
    {
        return asset('storage/photos/' . $this->photo);
    }
}
