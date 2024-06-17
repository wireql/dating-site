<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourites extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
    ];

    public function profile() {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }
}
