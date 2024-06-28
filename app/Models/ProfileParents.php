<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileParents extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'parent_id',
    ];

    public function parent() {
        return $this->belongsTo(Parents::class, 'parent_id');
    }
}
