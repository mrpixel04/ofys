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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_info_id'); // Foreign key to shop_infos table
            $table->string('activity_type'); // Camping, Hiking, etc.
            $table->string('name'); // Custom name for the activity
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->text('requirements')->nullable();
            $table->integer('min_participants')->default(1);
            $table->integer('max_participants')->nullable();
            $table->integer('duration_minutes')->nullable(); // Duration in minutes
            $table->decimal('price', 10, 2);
            $table->string('price_type'); // per_person, per_site, per_pack, time_slot_based
            $table->boolean('includes_gear')->default(false);
            $table->text('included_items')->nullable(); // JSON encoded list of items included
            $table->text('excluded_items')->nullable(); // JSON encoded list of items excluded
            $table->text('amenities')->nullable(); // JSON encoded list of amenities
            $table->text('rules')->nullable(); // JSON encoded list of rules
            $table->text('cancelation_policy')->nullable();
            $table->text('images')->nullable(); // JSON encoded list of image paths
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('shop_info_id')->references('id')->on('shop_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
