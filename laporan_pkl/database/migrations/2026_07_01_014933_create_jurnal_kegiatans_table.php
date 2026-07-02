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
        Schema::create('jurnal_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('hari_tanggal');
            $table->string('kompetensi');
            $table->string('topik_pekerjaan');
            $table->string('nilai_karakter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_kegiatans');
    }
};
