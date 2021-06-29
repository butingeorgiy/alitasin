<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int partner_id
 * @property string city
 */
class PartnerCity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'partner_id',
        'city'
    ];

    protected $primaryKey = null;

    public $incrementing = false;
}
