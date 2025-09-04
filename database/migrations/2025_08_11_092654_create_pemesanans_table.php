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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon', 15);
            $table->date('tanggal_berangkat');
            $table->integer('jumlah_orang');
            $table->integer('jumlah_jip');

            // relasi ke lokasi jemput
            $table->foreignId('lokasi_jemput_id')
                ->constrained('lokasi_jemputs')
                ->onDelete('cascade');

            // relasi ke paket wisata
            $table->foreignId('paket_id')
                ->constrained('paket_wisatas')
                ->onDelete('cascade');

            $table->string('jam_berangkat');
            $table->bigInteger('total');
            $table->string('status')->default('pending');
            $table->string('bukti_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
