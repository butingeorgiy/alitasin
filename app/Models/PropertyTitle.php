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
class PropertyTitle extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
