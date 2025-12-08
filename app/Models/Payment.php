<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_reference',
        'gateway',
        'status',
        'amount',
        'currency',
        'bill_id',
        'collection_id',
        'bill_url',
        'transaction_id',
        'transaction_status',
        'paid_at',
        'paid_amount',
        'x_signature',
        'gateway_response',
        'attempts',
        'last_attempt_at',
        'failure_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'last_attempt_at' => 'datetime',
        'gateway_response' => 'array',
    ];

    /**
     * Get the booking that owns the payment.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Generate a unique payment reference
     */
    public static function generateReference(): string
    {
        $prefix = 'PAY';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$timestamp}-{$random}";
    }

    /**
     * Get amount in cents (for payment gateways)
     */
    public function getAmountInCents(): int
    {
        return (int) ($this->amount * 100);
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is processing
     */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if payment is completed/paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'done';
    }

    /**
     * Check if payment failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Mark payment as processing
     */
    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',
            'attempts' => $this->attempts + 1,
            'last_attempt_at' => now(),
        ]);

        // Sync status to booking
        $this->booking->update(['payment_status' => 'processing']);
    }

    /**
     * Mark payment as successful
     */
    public function markAsPaid(array $transactionData = []): void
    {
        $this->update([
            'status' => 'done',
            'transaction_status' => 'paid',
            'paid_at' => now(),
            'gateway_response' => $transactionData,
        ]);

        // Sync status to booking and confirm it
        $this->booking->update([
            'payment_status' => 'done',
            'status' => 'confirmed',
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(?string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'transaction_status' => 'failed',
            'failure_reason' => $reason,
            'gateway_response' => array_merge(
                $this->gateway_response ?? [],
                ['failure_reason' => $reason, 'failed_at' => now()->toIso8601String()]
            ),
        ]);

        // Sync status to booking
        $this->booking->update(['payment_status' => 'failed']);
    }

    /**
     * Mark payment as refunded
     */
    public function markAsRefunded(?string $reason = null): void
    {
        $this->update([
            'status' => 'refunded',
            'gateway_response' => array_merge(
                $this->gateway_response ?? [],
                ['refund_reason' => $reason, 'refunded_at' => now()->toIso8601String()]
            ),
        ]);

        // Sync status to booking
        $this->booking->update(['payment_status' => 'refunded']);
    }

    /**
     * Reset payment for retry
     */
    public function resetForRetry(): void
    {
        $this->update([
            'bill_id' => null,
            'bill_url' => null,
            'transaction_id' => null,
            'transaction_status' => null,
            'status' => 'pending',
            'failure_reason' => null,
        ]);

        $this->booking->update(['payment_status' => 'pending']);
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'done' => 'bg-green-100 text-green-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Scope to get pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get processing payments
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope to get completed payments
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'done');
    }

    /**
     * Scope to get failed payments
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope to filter by gateway
     */
    public function scopeByGateway($query, string $gateway)
    {
        return $query->where('gateway', $gateway);
    }
}
