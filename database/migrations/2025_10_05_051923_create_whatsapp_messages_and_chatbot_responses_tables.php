<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // WhatsApp Messages Table
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique(); // Unique ID from BuzzBridge
            $table->string('from_phone'); // Customer phone number
            $table->string('from_name')->nullable(); // Customer name
            $table->text('message'); // Message content
            $table->enum('direction', ['incoming', 'outgoing'])->default('incoming'); // Message direction
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread'); // Message status
            $table->timestamp('received_at'); // When message was received
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null'); // Admin who replied
            $table->timestamps();

            // Indexes
            $table->index('from_phone');
            $table->index('status');
            $table->index('received_at');
        });

        // Chatbot Responses Table
        Schema::create('chatbot_responses', function (Blueprint $table) {
            $table->id();
            $table->string('keyword'); // Trigger keyword
            $table->text('response'); // Auto response message
            $table->boolean('is_active')->default(true); // Enable/disable response
            $table->integer('priority')->default(0); // Response priority (higher = checked first)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Admin who created
            $table->integer('usage_count')->default(0); // How many times this response was used
            $table->timestamp('last_used_at')->nullable(); // Last time this response was used
            $table->timestamps();

            // Indexes
            $table->index('keyword');
            $table->index('is_active');
            $table->index('priority');
        });

        // WhatsApp Sessions Table (for tracking QR code sessions)
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique(); // Session identifier
            $table->string('phone_number')->nullable(); // Connected WhatsApp number
            $table->enum('status', ['pending', 'active', 'disconnected'])->default('pending'); // Session status
            $table->text('qr_code')->nullable(); // QR code data
            $table->timestamp('connected_at')->nullable(); // When session became active
            $table->timestamp('disconnected_at')->nullable(); // When session disconnected
            $table->timestamps();

            // Indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sessions');
        Schema::dropIfExists('chatbot_responses');
        Schema::dropIfExists('whatsapp_messages');
    }
};
