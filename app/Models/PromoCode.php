<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder where(string $string, array|string|null $input)
 * @method static Builder find(int $promo_code_id)
 * @method static create(array $array)
 * @property integer id
 * @property integer sale_percent
 * @property string code
 */
class PromoCode extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
