<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any lowercase 'admin' roles to uppercase 'ADMIN'
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'ADMIN']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is optional, you can revert back if needed
        // DB::table('users')
        //     ->where('role', 'ADMIN')
        //     ->update(['role' => 'admin']);
    }
};
