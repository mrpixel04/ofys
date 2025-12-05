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
            $table->string('ssm_number')->nullable()->after('company_email');
            $table->string('einvoice_number')->nullable()->after('ssm_number');
            $table->string('bank_account_number')->nullable()->after('phone');
            $table->string('bank_name')->nullable()->after('bank_account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_infos', function (Blueprint $table) {
            $table->dropColumn([
                'ssm_number',
                'einvoice_number',
                'bank_account_number',
                'bank_name',
            ]);
        });
    }
};




