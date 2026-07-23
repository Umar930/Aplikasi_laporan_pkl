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
        Schema::create('laporan_harians',function(Blueprint $table){
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->integer('minggu_ke');
            $table->date('tanggal_hari');
            $table->string('kompetensi_dasar');
            $table->string('Topik_pembelajaran');
            $table->string('nilai_karakter_budaya');
            $table->enum('status_verifikasi',['pending','diverifikasi'])->default('pending');
            $table->foreignId('diverifikasi_oleh_admin')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('diverifikasi_oleh_dudi')->nullable()->constrained('identitas_dudi')->onDelete('set null');
            $table->foreignId('diverifikasi_oleh_guru')->nullable()->constrained('guru_pembimbings')->onDelete('set null');
            $table->timestamp('waktu_diverifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('laporan_harians');
    }
};
