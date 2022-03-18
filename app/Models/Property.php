<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

/**
 * @property int id
 * @property PropertyTitle title
 * @property PropertyDescription description
 * @property PropertyType type
 * @property Region region
 * @property Collection images
 * @property Collection params
 * @property int cost
 * @property CostUnit unit
 *
 * @property int title_id
 * @property int description_id
 * @property int type_id
 * @property int region_id
 * @property int cost_unit_id
 *
 * @mixin Builder
 */
class Property extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];


    # Model's relations

    /**
     * Property's title relation.
     *
     * @return BelongsTo
     */
    public function title(): BelongsTo
    {
        return $this->belongsTo(PropertyTitle::class);
    }

    /**
     * Property's description relation.
     *
     * @return BelongsTo
     */
    public function description(): BelongsTo
    {
        return $this->belongsTo(PropertyDescription::class);
    }

    /**
     * Property's type relation.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Property's region relation.
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Property's images relation.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Property's params relation.
     *
     * @return BelongsToMany
     */
    public function params(): BelongsToMany
    {
        return $this->belongsToMany(
            PropertyParam::class,
            'property_has_param',
            'property_id',
            'property_param_id'
        )->withPivot('en_value', 'ru_value', 'tr_value', 'ua_value');
    }

    /**
     * Property's orders relation.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(PropertyOrder::class);
    }

    /**
     * Property's unit relation.
     *
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(CostUnit::class, 'cost_unit_id');
    }


    # Other methods

    /**
     * Get title by current locale.
     *
     * @return string
     */
    public function getLocaleTitle(): string
    {
        /** @var PropertyTitle $propertyTitle */
        $propertyTitle = $this->title()->limit(1)->first();

        return $propertyTitle[App::getLocale()];
    }

    /**
     * Get description by current locale.
     *
     * @return string
     */
    public function getLocaleDescription(): string
    {
        /** @var PropertyDescription $propertyDescription */
        $propertyDescription = $this->description()->limit(1)->first();

        return $propertyDescription[App::getLocale()];
    }

    /**
     * Get region name by current locale.
     *
     * @return string
     */
    public function getLocaleRegion(): string
    {
        /** @var Region $region */
        $region = $this->region()->limit(1)->first();

        return $region->name;
    }

    /**
     * Get type by current locale.
     *
     * @return string
     */
    public function getLocaleType(): string
    {
        /** @var PropertyType $type */
        $type = $this->type()->limit(1)->first();

        return $type[App::getLocale() . '_name'];
    }

    /**
     * Get property images' url.
     *
     * @return array
     */
    public function getAllImagesUrl(): array
    {
        /** @var PropertyImage $image */
        foreach ($this->images()->orderByDesc('id')->get() as $image) {
            $images[] = $image->getAssetLink();
        }

        return $images ?? [];
    }

    /**
     * Get property's preview image.
     *
     * @return string|null
     */
    public function getPreviewImage(): ?string
    {
        /** @var PropertyImage $preview */
        $preview = $this->images()->where('is_main', '1')->limit(1)->first();

        return $preview ? $preview->getAssetLink() : null;
    }

    /**
     * Get property's extra images.
     *
     * @return array
     */
    public function getExtraImages(): array
    {
        /** @var PropertyImage $image */
        foreach ($this->images()->where('is_main', '0')->get() as $image) {
            $images[] = $image->getAssetLink();
        }

        return $images ?? [];
    }

    /**
     * Update property's title.
     *
     * @param string $en
     * @param string $ru
     * @param string $tr
     * @param string $ua
     */
    public function updateTitle(string $en, string $ru, string $tr, string $ua): void
    {
        $this->title->update(compact('en', 'ru', 'tr', 'ua'));
    }

    /**
     * Update property's description.
     *
     * @param string $en
     * @param string $ru
     * @param string $tr
     * @param string $ua
     */
    public function updateDescription(string $en, string $ru, string $tr, string $ua): void
    {
        $this->description->update(compact('en', 'ru', 'tr', 'ua'));
    }

    /**
     * Sync property's params.
     *
     * @param array $params
     */
    public function syncParams(array $params): void
    {
        $data = [];

        foreach ($params as $param) {
            $data[$param->id] = [
                'en_value' => $param->en_value,
                'ru_value' => $param->ru_value,
                'tr_value' => $param->tr_value,
                'ua_value' => $param->ua_value
            ];
        }

        if (count($data) > 0) {
            $this->params()->sync($data);
        } else {
            $this->params()->detach();
        }
    }

    /**
     * Get model of property's main image.
     *
     * @return Model|HasMany|object|null
     */
    public function mainImage()
    {
        return $this->images()->where('is_main', '1')->first();
    }
}
