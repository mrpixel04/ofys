<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'from_phone',
        'from_name',
        'message',
        'direction',
        'status',
        'received_at',
        'replied_by',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    /**
     * Get the admin who replied to this message
     */
    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Scope to get unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope to get messages by phone number
     */
    public function scopeByPhone($query, $phone)
    {
        return $query->where('from_phone', $phone);
    }

    /**
     * Scope to get incoming messages
     */
    public function scopeIncoming($query)
    {
        return $query->where('direction', 'incoming');
    }

    /**
     * Scope to get outgoing messages
     */
    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'outgoing');
    }
}
