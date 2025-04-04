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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('booking_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('participants')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'processing', 'done', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('cancelation_reason')->nullable();
            $table->json('customer_details')->nullable();
            $table->json('activity_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
