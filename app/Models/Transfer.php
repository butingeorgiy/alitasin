<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder where(string|array $param1, mixed $param2 = null, mixed $param3 = null)
 * @method static int count()
 */
class Transfer extends Model
{
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
}
