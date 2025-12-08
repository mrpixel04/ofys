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
        'lot_id',
        'booking_date',
        'start_time',
        'end_time',
        'participants',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
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
     * Get the activity lot associated with the booking.
     */
    public function lot()
    {
        return $this->belongsTo(ActivityLot::class, 'lot_id');
    }

    /**
     * Get the payment record for this booking.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    /**
     * Get all payment records for this booking (including retries).
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment is completed
     */
    public function isPaid()
    {
        return $this->payment_status === 'done';
    }

    /**
     * Check if payment failed
     */
    public function isFailed()
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Get total price in cents (for payment gateways)
     */
    public function getTotalPriceInCents()
    {
        return (int) ($this->total_price * 100);
    }

    /**
     * Create or get existing payment record
     */
    public function getOrCreatePayment(string $gateway = 'billplz'): Payment
    {
        // Check for existing pending/processing payment
        $existingPayment = $this->payments()
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->first();

        if ($existingPayment) {
            return $existingPayment;
        }

        // Create new payment
        return $this->payments()->create([
            'payment_reference' => Payment::generateReference(),
            'gateway' => $gateway,
            'status' => 'pending',
            'amount' => $this->total_price,
            'currency' => 'MYR',
        ]);
    }

    /**
     * Scope to get pending payments
     */
    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope to get paid bookings
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'done');
    }

    /**
     * Scope to get failed payments
     */
    public function scopeFailedPayment($query)
    {
        return $query->where('payment_status', 'failed');
    }
}
