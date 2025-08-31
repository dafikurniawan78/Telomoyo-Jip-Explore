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
        Schema::create('jips', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->integer('kapasitas')->default(4);
            $table->string('driver')->nullable();
            $table->enum('status', ['tersedia', 'tidak tersedia', 'digunakan'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jips');
    }
};
