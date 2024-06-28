<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'preference_id',
    ];

    public function preference() {
        return $this->belongsTo(Preferences::class, 'preference_id');
    }
    
}
