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
        Schema::create('bank_sampah_operating_hours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bank_sampah_id')
                ->constrained('bank_sampahs')
                ->cascadeOnDelete();

            $table->string('day');

            $table->time('open_time')->nullable();

            $table->time('close_time')->nullable();

            $table->boolean('is_closed')->default(false);

            $table->boolean('is_24_hours')->default(false);

            $table->boolean('is_unknown')->default(false);

            $table->timestamps();

            $table->index(['bank_sampah_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_sampah_operating_hours');
    }
};