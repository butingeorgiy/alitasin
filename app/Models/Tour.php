<?php

namespace App\Models;

use App\Facades\RusDecl;
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

    /**
     * Modify duration after retrieving
     *
     * @param $value
     * @return string|null
     */
    public function getDurationAttribute($value): ?string
    {
        $locale = \App::getLocale();
        $int = intval(explode('~', $value)[0] ?? null);
        $mode = explode('~', $value)[1] ?? null;

        if (!$int or !$mode) {
            return null;
        }

        if ($locale === 'ru') {
            $vars = ($mode === 'h' ? ['час', 'часа', 'часов'] : ['день', 'дня', 'дней']);
            return RusDecl::resolve($int, $vars);
        } else if ($locale === 'tr') {
            if ($int === 1) {
                return '1 ' . ($mode === 'd' ? 'saat' : 'gün');
            } else {
                return $int . ' ' . ($mode === 'd' ? 'saatler' : 'günler');
            }
        } else {
            if ($int === 1) {
                return '1 ' . ($mode === 'd' ? 'hour' : 'day');
            } else {
                return $int . ' ' . ($mode === 'd' ? 'hours' : 'days');
            }
        }
    }

    /**
     * Convert conducted_at field to array
     *
     * @param $value
     * @return array|null
     */
    public function getConductedAtAttribute($value): ?array
    {
        if (!$value) {
            return null;
        }

        return explode('~', $value);
    }
}
