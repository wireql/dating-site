<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserViewProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
    ];
}
