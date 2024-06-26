<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileHobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'hobby_id',
    ];

    public function hobby() {
        return $this->belongsTo(Hobby::class, 'hobby_id');
    }
}
