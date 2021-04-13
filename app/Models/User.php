<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public $timestamps = false;


    public function scopeByPhone($query, $phone)
    {
        return $query->where(DB::raw('CONCAT(phone_code, phone)'), $phone);
    }

    public function tokens()
    {
        return $this->hasMany(AuthToken::class)->where(
            DB::raw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at)'),
            '<',
            DB::raw('time_valid')
        );
    }

    /**
     * Get users with manager's access
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManagers($query)
    {
        return $query->where('account_type_id', '4');
    }
}
