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
        Schema::table('shop_infos', function (Blueprint $table) {
            // Activities
            if (!Schema::hasColumn('shop_infos', 'activities')) {
                $table->json('activities')->nullable();
            }
            if (!Schema::hasColumn('shop_infos', 'rules')) {
                $table->json('rules')->nullable();
            }
            if (!Schema::hasColumn('shop_infos', 'amenities')) {
                $table->json('amenities')->nullable();
            }

            // Operations
            if (!Schema::hasColumn('shop_infos', 'opening_hours')) {
                $table->json('opening_hours')->nullable();
            }
            if (!Schema::hasColumn('shop_infos', 'special_instructions')) {
                $table->string('special_instructions')->nullable();
            }
            if (!Schema::hasColumn('shop_infos', 'min_booking_time')) {
                $table->string('min_booking_time')->default('none');
            }
            if (!Schema::hasColumn('shop_infos', 'max_booking_time')) {
                $table->string('max_booking_time')->default('none');
            }

            // Packages and Pricing
            if (!Schema::hasColumn('shop_infos', 'packages')) {
                $table->json('packages')->nullable();
            }

            // Location
            if (!Schema::hasColumn('shop_infos', 'location_images')) {
                $table->json('location_images')->nullable();
            }

            // Promotions
            if (!Schema::hasColumn('shop_infos', 'promotions')) {
                $table->json('promotions')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_infos', function (Blueprint $table) {
            $columnsToCheck = [
                'activities',
                'rules',
                'amenities',
                'opening_hours',
                'special_instructions',
                'min_booking_time',
                'max_booking_time',
                'packages',
                'location_images',
                'promotions'
            ];

            // Only drop columns that exist
            $columnsToDrop = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('shop_infos', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
