<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string ru_name
 * @property string en_name
 * @property string tr_name
 * @property string ua_name
 *
 * @mixin Builder
 */
class TourType extends Model
{
    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get type's name according app locale
     *
     * @return Attribute
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this[app()->getLocale() . '_name']
        );
    }
}
