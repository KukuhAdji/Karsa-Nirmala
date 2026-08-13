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
        Schema::table('bank_sampahs', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('longitude');

            $table->string('status')
                ->default('Tidak diketahui')
                ->after('whatsapp');

            $table->string('waste_type')
                ->default('Tidak diketahui')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_sampahs', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp',
                'status',
                'waste_type',
            ]);
        });
    }
};