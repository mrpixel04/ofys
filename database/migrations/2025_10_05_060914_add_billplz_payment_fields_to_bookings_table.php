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
        Schema::table('bookings', function (Blueprint $table) {
            // Billplz Bill ID
            $table->string('billplz_bill_id')->nullable()->after('payment_id');

            // Billplz Collection ID
            $table->string('billplz_collection_id')->nullable()->after('billplz_bill_id');

            // Billplz Bill URL
            $table->string('billplz_url')->nullable()->after('billplz_collection_id');

            // Billplz Transaction ID (from callback)
            $table->string('billplz_transaction_id')->nullable()->after('billplz_url');

            // Billplz Transaction Status
            $table->string('billplz_transaction_status')->nullable()->after('billplz_transaction_id');

            // Billplz Paid At
            $table->timestamp('billplz_paid_at')->nullable()->after('billplz_transaction_status');

            // Billplz Paid Amount (in cents)
            $table->integer('billplz_paid_amount')->nullable()->after('billplz_paid_at');

            // Billplz X Signature (for security verification)
            $table->text('billplz_x_signature')->nullable()->after('billplz_paid_amount');

            // Payment Gateway Response (full JSON response)
            $table->json('payment_gateway_response')->nullable()->after('billplz_x_signature');

            // Payment Attempts Counter
            $table->integer('payment_attempts')->default(0)->after('payment_gateway_response');

            // Last Payment Attempt
            $table->timestamp('last_payment_attempt')->nullable()->after('payment_attempts');

            // Add index for faster queries
            $table->index('billplz_bill_id');
            $table->index('billplz_transaction_id');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['billplz_bill_id']);
            $table->dropIndex(['billplz_transaction_id']);
            $table->dropIndex(['payment_status']);

            $table->dropColumn([
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
            ]);
        });
    }
};
