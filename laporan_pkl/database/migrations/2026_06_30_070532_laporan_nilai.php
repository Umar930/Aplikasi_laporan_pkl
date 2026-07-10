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
            $table->date('tanggal_berakhir');
            $table->string('catatan')->nullable();
            $table->integer('kehadiran_sakit')->default('0');
            $table->integer('kehadiran_ijin')->default('0');
            $table->integer('kehadiran_tanpa_keterangan')->default('0');
            $table->timestamps();
        });

        Schema::create('laporan_nilai_details',function(Blueprint $table){
            $table->id();
            $table->foreignId('laporan_nilai_id')->constrained('laporan_nilais')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('Tujuan_Pembelajaran_indikator')->onDelete('cascade');
            $table->Integer('skor');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('laporan_nilais');
        Schema::dropIfExist('laporan_nilai_details');
    }
};
