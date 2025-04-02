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
        Schema::create('activity_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            $table->string('name');  // e.g. "Lot 1", "Lot 2"
            $table->text('description')->nullable();
            $table->integer('capacity')->default(1);  // How many units/spots in this lot
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Add index for faster lookups
            $table->index(['activity_id', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_lots');
    }
};
