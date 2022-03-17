<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubPartnerPercent extends Model
{
    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
