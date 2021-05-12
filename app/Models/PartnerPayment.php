<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int amount
 * @method static create(array $attributes)
 */
class PartnerPayment extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
