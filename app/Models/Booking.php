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
        'payment_id',
        'special_requests',
        'cancelation_reason',
        'customer_details',
        'activity_details',
        // Billplz fields
        'billplz_bill_id',
        'billplz_collection_id',
        'billplz_url',
        'billplz_transaction_id',
        'billplz_transaction_status',
        'billplz_paid_at',
        'billplz_paid_amount',
        'billplz_x_signature',
        'payment_gateway_response',
        'payment_attempts',
        'last_payment_attempt',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'customer_details' => 'array',
        'activity_details' => 'array',
        'total_price' => 'decimal:2',
        'billplz_paid_at' => 'datetime',
        'last_payment_attempt' => 'datetime',
        'payment_gateway_response' => 'array',
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
     * Get total price in cents (for Billplz)
     */
    public function getTotalPriceInCents()
    {
        return (int) ($this->total_price * 100);
    }

    /**
     * Mark payment as processing
     */
    public function markAsProcessing()
    {
        $this->update([
            'payment_status' => 'processing',
            'payment_attempts' => $this->payment_attempts + 1,
            'last_payment_attempt' => now(),
        ]);
    }

    /**
     * Mark payment as successful
     */
    public function markAsPaid($transactionData = [])
    {
        $this->update([
            'payment_status' => 'done',
            'status' => 'confirmed',
            'billplz_transaction_status' => 'paid',
            'billplz_paid_at' => now(),
            'payment_gateway_response' => $transactionData,
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed($reason = null)
    {
        $this->update([
            'payment_status' => 'failed',
            'billplz_transaction_status' => 'failed',
            'payment_gateway_response' => array_merge(
                $this->payment_gateway_response ?? [],
                ['failure_reason' => $reason, 'failed_at' => now()->toIso8601String()]
            ),
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
