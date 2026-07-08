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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('guru_pembimbings',function(Blueprint $table){
            $table->id();
            $table->string('nama');
            $table->string('nip',20);
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('identitas_dudi',function (Blueprint $table){
            $table->id();
            $table->string('nama_dudi');
            $table->string('alamat_dudi');
            $table->string('no_telepon');
            $table->string('nama_pembimbing');
            $table->string('email')->unique();
            $table->string('password');
        });

        Schema::create('murid', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas');
            $table->foreignId('konsentrasi_keahlian_id')->constrained('konsentrasi_keahlian')->onDelete('cascade');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nis');
            $table->enum('jenis_kelamin',['pria','wanita'])->default('pria');
            $table->string('alamat_siswa');
            $table->string('alamat_wali_ortu');
            $table->string('golongan_darah')->nullable();
            $table->string('catatan_kesehatan')->nullable();
            $table->string('nama_wali_ortu');
            $table->string('no_telepon');
            $table->string('no_telepon_wali');
            $table->foreignId('dudi_id')->constrained('identitas_dudi')->onDelete('cascade');
            $table->foreignId('guru_pembimbing_id')->constrained('guru_pembimbings')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('murid');
        Schema::dropIfExists('sessions');
    }
};
