<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'code',
    ];

    static public function createCode($hash, $code) {
        return UserCode::create([
            'hash' => $hash,
            'code' => $code
        ]);
    }
}
