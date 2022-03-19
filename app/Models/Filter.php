<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get filter's name according app locale.
     *
     * @return Attribute
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this[app()->getLocale() . '_name']
        );
    }
}
