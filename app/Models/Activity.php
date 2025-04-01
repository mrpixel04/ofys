<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_info_id',
        'activity_type',
        'name',
        'description',
        'location',
        'requirements',
        'min_participants',
        'max_participants',
        'duration_minutes',
        'price',
        'price_type',
        'includes_gear',
        'included_items',
        'excluded_items',
        'amenities',
        'rules',
        'cancelation_policy',
        'images',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_participants' => 'integer',
        'max_participants' => 'integer',
        'duration_minutes' => 'integer',
        'price' => 'decimal:2',
        'includes_gear' => 'boolean',
        'included_items' => 'array',
        'excluded_items' => 'array',
        'amenities' => 'array',
        'rules' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the shop info that owns the activity.
     */
    public function shopInfo()
    {
        return $this->belongsTo(ShopInfo::class);
    }

    /**
     * Get the formatted price type for display.
     */
    public function getPriceTypeFormattedAttribute()
    {
        $formats = [
            'per_person' => 'Per Person',
            'per_site' => 'Per Site',
            'per_pack' => 'Per Pack',
            'time_slot_based' => 'Time Slot Based'
        ];

        return $formats[$this->price_type] ?? ucfirst(str_replace('_', ' ', $this->price_type));
    }

    /**
     * Get the activity types available.
     */
    public static function getActivityTypes()
    {
        return [
            'camping' => 'Camping',
            'glamping' => 'Glamping',
            'houseboat' => 'Houseboat',
            'hiking' => 'Hiking',
            'trekking' => 'Trekking',
            'diving' => 'Diving',
            'water_rafting' => 'Water Rafting',
            'zoo' => 'Zoo',
            'climbing' => 'Climbing',
            'cave_tour' => 'Cave Tour',
            'boating' => 'Boating',
            'waterpark' => 'Waterpark',
            'surfing' => 'Surfing',
            'atv' => 'ATV',
            'zipline' => 'Zipline',
            'extreme_park' => 'Extreme Park',
        ];
    }

    /**
     * Get the price types available.
     */
    public static function getPriceTypes()
    {
        return [
            'per_person' => 'Per Person',
            'per_site' => 'Per Site',
            'per_pack' => 'Per Pack',
            'time_slot_based' => 'Time Slot Based',
        ];
    }
}
