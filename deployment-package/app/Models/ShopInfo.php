<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopInfo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'business_type',
        'logo',
        'shop_image',
        'description',
        'services_offered',
        'price_range',
        'has_discount',
        'discount_info',
        'address',
        'city',
        'state',
        'postal_code',
        'zip',
        'country',
        'phone',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'is_verified',
        'is_featured',
        // Activities
        'activities',
        'rules',
        'amenities',
        // Operations
        'opening_hours',
        'business_hours',
        'special_instructions',
        'min_booking_time',
        'max_booking_time',
        // Packages and Pricing
        'packages',
        // Location
        'location_images',
        // Promotions
        'promotions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_discount' => 'boolean',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'activities' => 'array',
        'rules' => 'array',
        'amenities' => 'array',
        'opening_hours' => 'array',
        'packages' => 'array',
        'location_images' => 'array',
        'promotions' => 'array',
    ];

    /**
     * Get the user that owns the shop information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activities for the shop.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
