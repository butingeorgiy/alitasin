<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SafeVar extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'value'
    ];


    public function scopeValid($query)
    {
        return $query->where(
            DB::raw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at)'),
            '<',
            DB::raw('time_valid')
        );
    }
}
