<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $id)
 */
class Ticket extends Model
{
    public $timestamps = false;


    public function getNameAttribute(): string
    {
        return $this[\App::getLocale() . '_name'];
    }

    public function getCost($initCost)
    {
        $percent = intval($this->percent_from_init_cost);

        if ($percent === 0) {
            return 0;
        }

        return $initCost * $percent / 100;
    }

    public function getPercent()
    {
        return $this->percent_from_init_cost;
    }
}
