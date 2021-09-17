<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string brand
 * @property string model
 * @property string show_at_index_page
 * @property int cost
 * @property mixed images
 * @property mixed params
 * @property string|null main_image
 * @property string[] extra_images
 * @property VehicleType type
 * @property Region region
 *
 * @mixin Builder
 */
class Vehicle extends Model
{
    use SoftDeletes;


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
     * Get vehicle's region.
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
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
     * Get vehicle's all images
     *
     * @return array
     */
    public function getAllImagesUrl(): array
    {
        foreach ($this->images()->orderByDesc('is_main')->get() as $image) {
            $images[] = asset('storage/vehicle_pictures/' . $image->image);
        }

        return $images ?? [];
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
                return asset('storage/vehicle_pictures/' . $image->image);
            }
        }

        return null;
    }

    /**
     * Get vehicle's extra images
     *
     * @return array
     */
    public function getExtraImagesAttribute(): array
    {
        foreach ($this->images as $image) {
            if (!$image->isMain()) {
                $images[] = asset('storage/vehicle_pictures/' . $image->image);
            }
        }

        return $images ?? [];
    }

    /**
     * Get vehicle's main image instance.
     *
     * @return Model|HasMany|object|null
     */
    public function mainImage()
    {
        return $this->images()->where('is_main', '1')
            ->limit(1)->first();
    }
}
