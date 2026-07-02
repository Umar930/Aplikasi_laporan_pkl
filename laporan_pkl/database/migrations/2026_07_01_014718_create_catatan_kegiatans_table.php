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
        Schema::create('catatan_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pekerjaan');
            $table->string('perencanaan_kegiatan');
            $table->string('pelaksanaan_kegiatan');
            $table->string('catatan_instruktur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_kegiatans');
    }
};
