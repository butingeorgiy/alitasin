<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection<TelegramPrivilege> privileges
 * @method static Builder byPhone(string $phone)
 *
 * @mixin Builder
 */
class TelegramChat extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get privileges.
     *
     * @return BelongsToMany
     */
    public function privileges(): BelongsToMany
    {
        return $this->belongsToMany(TelegramPrivilege::class,
            'telegram_chat_has_privilege',
            'chat_id',
            'privilege_id'
        );
    }

    /**
     * Get Telegram chat by phone number.
     *
     * @param Builder $query
     * @param string $phone
     * @return Builder
     */
    public function scopeByPhone(Builder $query, string $phone): Builder
    {
        return $query->where('phone_number', $phone)->limit(1);
    }
}
