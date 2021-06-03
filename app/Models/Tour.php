<?php

namespace App\Models;

use App\Facades\RusDecl;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @method static Tour find(mixed $tourId)
 * @method static findOrFail($id)
 * @method static byManager($managerId)
 * @property mixed id
 * @property array conducted_at
 * @property mixed manager_id
 * @property array|mixed|string|null price
 * @property mixed|string available_time
 * @property array|mixed|string|null duration
 * @property mixed images
 * @property mixed title
 * @property mixed description
 * @property mixed type
 * @property mixed region
 * @property mixed manager
 * @property mixed additions
 * @property string|null departure_time
 * @property string|null check_out_time
 * @property string|null execution_period
 */
class Tour extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];


    /**
     * Tours that belong to specific manager
     *
     * @param $query
     * @param $managerId
     */
    public function scopeByManager($query, $managerId)
    {
        $query->where('manager_id', $managerId);
    }

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
     * Get tour's additions
     *
     * @return BelongsToMany
     */
    public function additions(): BelongsToMany
    {
        return $this->belongsToMany(Addition::class, 'tours_has_additions')->withPivot('is_include', 'en_description', 'ru_description', 'tr_description');
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

        if ($locale === 'ru' || $locale === 'ua') {
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
    public function getConductedAtAttribute($value): array
    {
        if (!$value) {
            return [];
        }

        return explode('~', $value);
    }

    /**
     * Convert available_time field to array
     *
     * @param $value
     * @return array|null
     */
    public function getAvailableTimeAttribute($value): array
    {
        if (!$value) {
            return [];
        }

        return explode('~', $value);
    }

    /**
     * Check if time available for reservation
     *
     * @param string $time
     * @return bool
     */
    public function isTimeAvailable(string $time): bool
    {
        return collect(explode('~', $this->getOriginal('available_time')))->contains($time);
    }

    public function isDateAvailable(string $date): bool
    {
        $parsedDate = Carbon::parse($date)->dayOfWeek;

        foreach ($this->conducted_at as $day) {
            switch ($day) {
                case 'mon':
                    if ($parsedDate === 1) {
                        return true;
                    }
                    break;
                case 'tue':
                    if ($parsedDate === 2) {
                        return true;
                    }
                    break;
                case 'wed':
                    if ($parsedDate === 3) {
                        return true;
                    }
                    break;
                case 'thu':
                    if ($parsedDate === 4) {
                        return true;
                    }
                    break;
                case 'fri':
                    if ($parsedDate === 5) {
                        return true;
                    }
                    break;
                case 'sat':
                    if ($parsedDate === 6) {
                        return true;
                    }
                    break;
                case 'sun':
                    if ($parsedDate === 0) {
                        return true;
                    }
                    break;
            }
        }

        return false;
    }

    public function scopeSearch($query, string $searchString)
    {
        return $query->selectRaw(
            'CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(LOWER(REPLACE(tour_titles.' . \App::getLocale() . ', \' \', \'\')), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency',
            [str_replace(' ', '|', $searchString)]
        )->having('frequency', '>', 0)->orderByDesc('frequency');
    }

    public function getDepartureTimeAttribute(): ?string
    {
        if (!$this->getOriginal('departure_time')) {
            return null;
        }

        return Carbon::parse($this->getOriginal('departure_time'))->format('H:i');
    }

    public function getCheckOutTimeAttribute(): ?string
    {
        if (!$this->getOriginal('check_out_time')) {
            return null;
        }

        return Carbon::parse($this->getOriginal('check_out_time'))->format('H:i');
    }

    public function getExecutionPeriodAttribute(): ?string
    {
        if (!$this->departure_time or !$this->check_out_time) {
            return null;
        }

        return Carbon::parse($this->departure_time)->format('H:i') . ' – ' .
            Carbon::parse($this->check_out_time)->format('H:i');
    }
}
