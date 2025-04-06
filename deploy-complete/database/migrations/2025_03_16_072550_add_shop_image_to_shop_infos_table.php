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
            // Add shop_image column if it doesn't exist
            if (!Schema::hasColumn('shop_infos', 'shop_image')) {
                $table->string('shop_image')->nullable()->after('logo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_infos', function (Blueprint $table) {
            // Remove shop_image column if it exists
            if (Schema::hasColumn('shop_infos', 'shop_image')) {
                $table->dropColumn('shop_image');
            }
        });
    }
};
