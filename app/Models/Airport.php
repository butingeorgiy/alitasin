<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Airport|Collection|null find(mixed $primaryKey)
 * @property string en_name
 * @property string ru_name
 * @property string tr_name
 * @property string ua_name
 * @property string|null name
 */
class Airport extends Model
{
    use SoftDeletes;

    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @inheritdoc
     *
     * @var string[]
     */
    protected $appends = ['name'];

    /**
     * Get localized name.
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
