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
       Schema::create('observasi',function(Blueprint $table){
        $table->id();
        $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
        $table->foreignId('guru_pembimbing_id')->constrained('guru_pembimbings')->onDelete('cascade');
        $table->string('pekerjaan_proyek');
        $table->enum('status_verifikasi',['pending','diverifikasi'])->default('pending');
        $table->foreignId('diverifikasi_oleh_guru')->nullable()->constrained('guru_pembimbings')->onDelete('set null');
        $table->foreignId('diverifikasi_oleh_dudi')->nullable()->constrained('identitas_dudi')->onDelete('set null');
        $table->timestamps(); 
       });

       Schema::create('observasi_details',function(Blueprint $table){
            $table->id();
            $table->foreignId('observasi_id')->constrained('observasi')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('tujuan_pembelajaran_indikator')->onDelete('cascade');
            $table->enum('ketercapaian',['iya','tidak'])->default('iya');
            $table->string('deskripsi');
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('observasi');
        Schema::dropIfExist('observasi_details');
    }
};
