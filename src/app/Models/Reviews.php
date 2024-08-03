<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(\App\User::class, 'user_id', 'id')->select('id', 'name');
    }
}