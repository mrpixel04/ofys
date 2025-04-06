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
        Schema::table('users', function (Blueprint $table) {
            // First check if the column exists
            if (!Schema::hasColumn('users', 'username')) {
                // Add the column if it doesn't exist
                $table->string('username', 100)->after('email')->nullable();
            } else {
                // Modify the column if it exists
                $table->string('username', 100)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                // If we need to revert, just set it back to a smaller size
                // or you could drop the column if it was added by this migration
                $table->string('username', 50)->change();
            }
        });
    }
};
