<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'state',
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
     * Get the provider (user) that owns this activity through the shop info
     */
    public function provider()
    {
        return $this->shopInfo ? $this->shopInfo->user() : null;
    }

    /**
     * Get the lots associated with this activity.
     */
    public function lots()
    {
        return $this->hasMany(ActivityLot::class);
    }

    /**
     * Check if this activity type requires lots
     */
    public function requiresLots()
    {
        return in_array($this->activity_type, ['camping', 'glamping']);
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

    /**
     * Get the Malaysian states for dropdown.
     */
    public static function getMalaysianStates()
    {
        return [
            'johor' => 'Johor',
            'kedah' => 'Kedah',
            'kelantan' => 'Kelantan',
            'melaka' => 'Melaka',
            'negeri_sembilan' => 'Negeri Sembilan',
            'pahang' => 'Pahang',
            'perak' => 'Perak',
            'perlis' => 'Perlis',
            'pulau_pinang' => 'Pulau Pinang',
            'sabah' => 'Sabah',
            'sarawak' => 'Sarawak',
            'selangor' => 'Selangor',
            'terengganu' => 'Terengganu',
            'wp_kuala_lumpur' => 'Wilayah Persekutuan Kuala Lumpur',
            'wp_labuan' => 'Wilayah Persekutuan Labuan',
            'wp_putrajaya' => 'Wilayah Persekutuan Putrajaya',
        ];
    }

    public static function getIncludedItemOptions()
    {
        return [
            'tent' => '⛺ Tent',
            'sleeping_bag' => '🛌 Sleeping Bag',
            'backpack' => '🎒 Backpack',
            'hiking_boots' => '🥾 Hiking Boots',
            'helmet' => '⛑️ Safety Helmet',
            'life_jacket' => '🦺 Life Jacket',
            'rope' => '🪢 Climbing Rope',
            'harness' => '🔗 Safety Harness',
            'flashlight' => '🔦 Flashlight',
            'first_aid' => '🏥 First Aid Kit',
            'water_bottle' => '💧 Water Bottle',
            'map_compass' => '🧭 Map & Compass',
            'fishing_gear' => '🎣 Fishing Gear',
            'camping_chair' => '🪑 Camping Chair',
            'portable_stove' => '🔥 Portable Stove',
            'cooler' => '🧊 Cooler Box',
        ];
    }

    public static function getExcludedItemOptions()
    {
        return [
            'food' => '🍽️ Food & Meals',
            'transport' => '🚗 Transportation',
            'insurance' => '🛡️ Travel Insurance',
            'personal_items' => '🧳 Personal Items',
            'alcohol' => '🍺 Alcoholic Drinks',
            'souvenirs' => '🎁 Souvenirs',
            'laundry' => '🧺 Laundry Service',
            'wifi' => '📶 WiFi Access',
            'tips' => '💰 Tips & Gratuities',
            'parking' => '🅿️ Parking Fees',
            'entrance_fees' => '🎫 Entrance Fees',
            'medical' => '💊 Medical Expenses',
        ];
    }

    public static function getAmenityOptions()
    {
        return [
            'wifi' => '📶 WiFi',
            'parking' => '🅿️ Free Parking',
            'restroom' => '🚻 Clean Restrooms',
            'shower' => '🚿 Hot Showers',
            'restaurant' => '🍴 On-site Restaurant',
            'shop' => '🛒 Convenience Store',
            'laundry' => '🧺 Laundry Facilities',
            'bbq' => '🔥 BBQ Area',
            'playground' => '🛝 Kids Playground',
            'pool' => '🏊 Swimming Pool',
            'gym' => '💪 Fitness Center',
            'spa' => '🧘 Spa Services',
        ];
    }

    public static function getRuleOptions()
    {
        return [
            'no_smoking' => '🚭 No Smoking',
            'no_pets' => '🐕‍🦺 No Pets Allowed',
            'no_alcohol' => '🚫 No Alcohol',
            'quiet_hours' => '🤫 Quiet Hours (10 PM - 6 AM)',
            'age_restriction' => '🔞 Age Restrictions Apply',
            'fitness_required' => '💪 Good Physical Fitness Required',
            'weather_dependent' => '🌤️ Weather Dependent Activity',
            'advance_booking' => '📅 Advance Booking Required',
        ];
    }

    /**
     * Resolve the primary image URL for public listings.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        $imagePath = null;

        if (is_array($this->images) && count($this->images) > 0) {
            $imagePath = $this->images[0];
        } elseif (!empty($this->image)) {
            $imagePath = $this->image;
        }

        if (!$imagePath) {
            return null;
        }

        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        return Storage::disk('public')->url($imagePath);
    }
}
