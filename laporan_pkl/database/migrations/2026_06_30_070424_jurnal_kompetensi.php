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
        Schema::create('jurnal_kompetensi', function(Blueprint $table){
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('details_jurnal',function(Blueprint $table){
            $table->id();
            $table->foreignId('jurnal_kompetensi_id')->constrained('jurnal_kompetensi')->onDelete('cascade');
            $table->foreignId('kompetensi_dasar_id')->constrained('kompetensi_dasars')->onDelete('cascade');
            $table->enum('pelaksanaan_pembelajaran',['Sekolah','Dunia Kerja','Sekolah Dan Dunia Kerja'])->default('Sekolah Dan Dunia Kerja');
            $table->integer('nilai_minimal_kompetensi');
            $table->integer('nilai_kompetensi');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->enum('status_diverifikasi',['pending','diverifikasi'])->default('pending');
            $table->foreignId('diverifikasi_oleh_guru')->nullable()->constrained('guru_pembimbings')->onDelete('set null');
            $table->foreignId('diverifikasi_oleh_dudi')->nullable()->constrained('identitas_dudi')->onDelete('set null');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('jurnal_kompetensi');
        Schema::dropIfExists('details_jurnal');
    }
};