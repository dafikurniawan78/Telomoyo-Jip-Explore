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
        Schema::create('alokasi_jips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrean_id')->constrained('antreans')->onDelete('cascade');
            $table->foreignId('jip_id')->constrained('jips')->onDelete('cascade');
            $table->timestamp('waktu_mulai')->nullable()->index();
            $table->timestamp('waktu_selesai')->nullable()->index();
            $table->timestamps();
            $table->unique(['antrean_id', 'jip_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_jips');
    }
};
