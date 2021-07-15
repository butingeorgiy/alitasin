<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $brand
 * @property string $model
 * @property string $show_at_index_page
 * @property int $cost
 * @property mixed images
 * @property mixed params
 * @method static Vehicle|null find($id)
 * @method static Vehicle findOrFail($id)
 * @method static Builder where(string|array $param1, mixed $param2 = null, mixed $param3 = null)
 */
class Vehicle extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    /**
     * Get vehicle's type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    /**
     * Get vehicle's images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

    /**
     * Get vehicle's params
     *
     * @return BelongsToMany
     */
    public function params(): BelongsToMany
    {
        return $this->belongsToMany(
            VehicleParam::class,
            'vehicle_has_param',
            'vehicle_id',
            'vehicle_param_id'
        )->withPivot('en_value', 'ru_value', 'tr_value', 'ua_value');
    }

    /**
     * Get vehicle's orders
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(VehicleOrder::class);
    }

    /**
     * Need to show at index page
     *
     * @return bool
     */
    public function isShowAtIndexPage(): bool
    {
        return $this->show_at_index_page === '1';
    }

    /**
     * Get vehicle's main image
     *
     * @return string|null
     */
    public function getMainImageAttribute(): ?string
    {
        foreach ($this->images as $image) {
            if ($image->isMain()) {
                return route('get-image', [
                    'dir' => 'vehicle_pictures',
                    'file' => $image->image
                ]);
            }
        }

        return null;
    }
}
