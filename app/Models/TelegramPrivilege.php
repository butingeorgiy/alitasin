<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder byAlias(string $alias)
 *
 * @mixin Builder
 */
class TelegramPrivilege extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Local scope for byAlias() static method.
     *
     * @param Builder $query
     * @param string $alias
     * @return Builder
     */
    public function scopeByAlias(Builder $query, string $alias): Builder
    {
        return $query->where('alias', $alias);
    }
}
