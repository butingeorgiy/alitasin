<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get tour's title
     *
     * @return BelongsTo
     */
    public function title(): BelongsTo
    {
        return $this->belongsTo(TourTitle::class, 'tour_title_id');
    }

    /**
     * Get tour's description
     *
     * @return BelongsTo
     */
    public function description(): BelongsTo
    {
        return $this->belongsTo(TourDescription::class, 'tour_description_id');
    }

    /**
     * Get tour's manager
     *
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get tour's region
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get tour's images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class, 'tour_id', 'id');
    }

    /**
     * Get tour's filters
     *
     * @return BelongsToMany
     */
    public function filters(): BelongsToMany
    {
        return $this->belongsToMany(Filter::class, 'tours_has_filters');
    }

    /**
     * Get tour's type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TourType::class, 'tour_type_id');
    }

    /**
     * Get tour's main image
     *
     * @return Collection
     */
    public function mainImage(): Collection
    {
        return $this->images()->where('is_main', '1')->get();
    }

    public function getDurationAttribute()
    {
        //
    }
}
