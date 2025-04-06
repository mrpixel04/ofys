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
            // Add company_email column if it doesn't exist
            if (!Schema::hasColumn('shop_infos', 'company_email')) {
                $table->string('company_email')->nullable()->after('company_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_infos', function (Blueprint $table) {
            // Remove company_email column if it exists
            if (Schema::hasColumn('shop_infos', 'company_email')) {
                $table->dropColumn('company_email');
            }
        });
    }
};
