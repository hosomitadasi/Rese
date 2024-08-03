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

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function checkIfFavorite()
    {
        return $this->favorites()->where('user_id', Auth::id())->exists();
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
}
