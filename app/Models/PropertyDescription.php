<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string en
 * @property string ru
 * @property string tr
 * @property string ua
 *
 * @mixin Builder
 */
class PropertyDescription extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
