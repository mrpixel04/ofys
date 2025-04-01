<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'activity_id',
        'booking_date',
        'start_time',
        'end_time',
        'participants',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'payment_id',
        'special_requests',
        'cancelation_reason',
        'customer_details',
        'activity_details',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'customer_details' => 'array',
        'activity_details' => 'array',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activity associated with the booking.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get formatted booking reference
     */
    public function getFormattedReferenceAttribute()
    {
        return '#BK-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->booking_date->format('M d, Y');
    }

    /**
     * Get formatted time
     */
    public function getFormattedTimeAttribute()
    {
        return $this->start_time->format('h:i A');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'done' => 'bg-green-100 text-green-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
