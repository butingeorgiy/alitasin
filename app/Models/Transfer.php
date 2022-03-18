<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 *
 * @mixin Builder
 */
class Transfer extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    /**
     * Get transfer's variations.
     *
     * @return HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(TransferCost::class);
    }

    /**
     * Get transfer cost by type and capacity.
     * If transfer variation not found will be
     * returned NULL.
     *
     * @param int $typeId
     * @param int $capacityId
     * @return float|null
     */
    public function getCost(int $typeId, int $capacityId): ?float
    {
        /** @var TransferCost|null $transferVariation */
        $transferVariation = $this->variations()->where([
            ['capacity_id', $capacityId],
            ['type_id', $typeId],
        ])->limit(1)->first();

        if ($transferVariation) {
            return $transferVariation->cost;
        }

        return null;
    }

    /**
     * Local scope for matchedBy static method.
     *
     * @param Builder $query
     * @param int $airportId
     * @param int $destinationId
     * @return Builder
     */
    public function scopeMatchedBy(Builder $query, int $airportId, int $destinationId): Builder
    {
        return $query->where([
            ['airport_id', $airportId],
            ['destination_id', $destinationId]
        ]);
    }
}
