<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthToken extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'token'
    ];
}
