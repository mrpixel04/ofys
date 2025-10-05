<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'phone_number',
        'status',
        'qr_code',
        'connected_at',
        'disconnected_at',
    ];

    protected $casts = [
        'connected_at' => 'datetime',
        'disconnected_at' => 'datetime',
    ];

    /**
     * Scope to get active session
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get pending sessions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if session is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Mark session as connected
     */
    public function markAsConnected($phoneNumber)
    {
        $this->update([
            'status' => 'active',
            'phone_number' => $phoneNumber,
            'connected_at' => now(),
        ]);
    }

    /**
     * Mark session as disconnected
     */
    public function markAsDisconnected()
    {
        $this->update([
            'status' => 'disconnected',
            'disconnected_at' => now(),
        ]);
    }
}
