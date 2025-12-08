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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('payment_reference')->unique();

            // Payment gateway info
            $table->string('gateway')->default('billplz'); // billplz, manual, cash, etc.
            $table->string('status')->default('pending'); // pending, processing, done, failed, refunded

            // Amount info
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('MYR');

            // Billplz specific fields (gateway-agnostic naming)
            $table->string('bill_id')->nullable(); // billplz_bill_id
            $table->string('collection_id')->nullable(); // billplz_collection_id
            $table->string('bill_url')->nullable(); // billplz_url
            $table->string('transaction_id')->nullable(); // billplz_transaction_id
            $table->string('transaction_status')->nullable(); // billplz_transaction_status
            $table->timestamp('paid_at')->nullable(); // billplz_paid_at
            $table->integer('paid_amount')->nullable(); // Amount in cents
            $table->text('x_signature')->nullable(); // For security verification

            // Gateway response
            $table->json('gateway_response')->nullable(); // Full JSON response

            // Attempt tracking
            $table->integer('attempts')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->text('failure_reason')->nullable();

            $table->timestamps();

            // Indexes for faster queries
            $table->index('bill_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('gateway');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
