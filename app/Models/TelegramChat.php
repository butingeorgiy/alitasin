<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection<TelegramPrivilege> privileges
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
}
