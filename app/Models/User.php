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

    public function getPhoneAttribute(): ?string
    {
        $phoneCode = $this->phone_code;
        $phone = $this->getOriginal('phone');

        if (!$phoneCode or !$phone) {
            return null;
        }

        if(preg_match( '/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/', $phoneCode . $phone,  $matches)) {
            return $matches[1] . ' ' . $matches[2] . ' ' .$matches[3] . ' ' . $matches[4];
        }

        return null;
    }

    public function getFullNameAttribute(): string
    {
        $firstName = $this->first_name;
        $lastName = $this->last_name;

        if (!$lastName) {
            return $firstName;
        } else {
            return $lastName . ' ' . $firstName;
        }
    }
}
