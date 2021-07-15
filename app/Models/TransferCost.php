<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $cost
 */
class TransferCost extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $table = 'transfer_cost';
}
