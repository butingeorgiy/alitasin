<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthTokens extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'token'
    ];
}
