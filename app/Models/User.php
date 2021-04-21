<?php

namespace App\Models;

use App\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @method static isEmailUnique($email)
 * @method static find(array|string $id)
 * @property string first_name
 * @property string account_type_id
 * @property string last_name
 * @property string phone_code
 * @property string password
 * @property integer id
 */
class User extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function scopeIsEmailUnique($query, $email): bool
    {
        return $query->where('email', $email)->get()->first() === null;
    }

    public function tokens(): \Illuminate\Database\Eloquent\Relations\HasMany
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
    public function scopeManagers($query): \Illuminate\Database\Eloquent\Builder
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

    /**
     * @return string
     */
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

    public function generatePassword(): string
    {
        $randomPassword = Str::random(10);
        $this->password = Hash::make($randomPassword, $this);
        return $randomPassword;
    }
}
