<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int amount
 * @method static create(array $attributes)
 */
class PartnerPayment extends Model
{
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
}
