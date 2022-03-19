<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class CostUnit extends Model
{
    # Other method

    /**
     * Get unit's name by current locale.
     *
     * @return string|null
     */
    public function getLocaleName(): ?string
    {
        return $this[app()->getLocale() . '_name'];
    }
}
