<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float $cost
 * @method static Builder where(string|array $param1, mixed $param2 = null, mixed $param3 = null)
 */
class TransferCost extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $table = 'transfer_cost';

    protected $primaryKey = null;

    protected $keyType = null;

    public $incrementing = false;
}
