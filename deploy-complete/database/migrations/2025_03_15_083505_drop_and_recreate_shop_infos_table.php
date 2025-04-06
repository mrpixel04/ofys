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
        // Drop the existing table if it exists
        Schema::dropIfExists('shop_infos');

        // Create a new table with the correct structure
        Schema::create('shop_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Basic info
            $table->string('company_name');
            $table->string('business_type')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();

            // Services info
            $table->text('services_offered')->nullable();
            $table->text('price_range')->nullable();
            $table->boolean('has_discount')->default(false);
            $table->text('discount_info')->nullable();

            // Contact info
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Malaysia');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Social media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();

            // Status
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_infos');
    }
};
