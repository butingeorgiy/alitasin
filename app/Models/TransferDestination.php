<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

/**
 * @method static TransferDestination|Collection|null find(mixed $primaryKey)
 * @property string en_name
 * @property string ru_name
 * @property string tr_name
 * @property string ua_name
 */
class TransferDestination extends Model
{
    use SoftDeletes;


    public $timestamps = false;

    protected $guarded = [];

    protected $appends = ['name'];


    /**
     * Get localized name
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this[App::getLocale() . '_name'];
    }
}
