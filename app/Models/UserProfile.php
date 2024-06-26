<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';

    protected $fillable = [
        'id',
        'user_id',
        'image',
        'country',
        'city',
        'nationality',
        'profession',
        'work_place',
        'weight',
        'height',
        'status',
        'instagram',
        'telegram',
        'facebook',
        'education',
        'message',
        'child_trauma'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hobbies()
    {
        return $this->hasMany(ProfileHobby::class, 'profile_id');
    }

    public function preferences()
    {
        return $this->hasMany(ProfilePreference::class, 'profile_id');
    }

    public function about()
    {
        return $this->hasMany(ProfileAbout::class, 'profile_id');
    }

    public function parents()
    {
        return $this->hasMany(ProfileParents::class, 'profile_id');
    }

    public function getUsersActiveProfiles() {
        return UserProfile::query()
            ->with('user')
            ->whereNotNull('country')
            ->whereNotNull('city')
            ->whereNotNull('nationality')
            ->whereNotNull('profession')
            ->whereNotNull('work_place')
            ->whereNotNull('status')
            ->whereNotNull('height')
            ->whereNotNull('weight')
            ->whereNotNull('education')
            ->whereNotNull('image')
            ->get();
    }

}
