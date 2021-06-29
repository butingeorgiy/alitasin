<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int partner_id
 * @property array|mixed|string|null city
 */
class PartnerCity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'partner_id',
        'city'
    ];

    public $primaryKey = null;
}
