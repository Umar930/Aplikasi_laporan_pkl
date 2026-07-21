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
        Schema::create('laporan_bulanans',function(Blueprint $table){
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->foreignId('dudi_id')->constrained('identitas_dudi')->onDelete('cascade');
            $table->foreignId('guru_pembimbing_id')->constrained('guru_pembimbings')->onDelete('cascade');
            $table->string('nama_pekerjaan');
            $table->string('perencanaan_kegiatan');
            $table->string('pelaksanaan_kegiatan');
            $table->text('catatan_instruktur')->nullable();
            $table->enum('status_verifikasi',['pending','diverifikasi'])->default('pending');
            $table->foreignId('diverifikasi_oleh_dudi')->nullable()->constrained('identitas_dudi')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanans');
    }
};
