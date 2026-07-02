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
        Schema::create('jurnal_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->string('kompetensi_dasar');
            $table->string('pelaksanaan_pembelajaran');
            $table->string('nilai_minimal_kompetensi');
            $table->string('nilai_kompetensi');
            $table->string('tanggal');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_kompetensis');
    }
};
