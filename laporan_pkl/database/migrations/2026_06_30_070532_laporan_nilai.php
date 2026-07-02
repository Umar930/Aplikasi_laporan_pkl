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
        Schema::create('laporan_nilais',function(Blueprint $table){
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->integer('nisn');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berkahir');
            $table->foreignId('indikator_id')->constrained('tujuan_pembelajaran_indikator')->onDelete('cascade');
            $table->integer('skor');
            $table->string('deskripsi')->nullable();
            $table->string('catatan')->nullable();
            $table->integer('kehadiran_sakit');
            $table->integer('kehadiran_ijin');
            $table->integer('kehadiran_tanpa_keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('laporan_nilais');
    }
};
