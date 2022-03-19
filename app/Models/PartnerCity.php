<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int partner_id
 * @property string city
 */
class PartnerCity extends Model
{
    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     *
     * @var string[]
     */
    protected $fillable = [
        'partner_id',
        'city'
    ];

    /**
     * @inheritdoc
     *
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $incrementing = false;
}
