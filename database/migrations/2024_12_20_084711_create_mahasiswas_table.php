<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->string('nama');
            $table->string('nim');
            $table->string('kelas');
            $table->string('no_telp');
            $table->string('asal_kota');
            $table->string('asal_provinsi');
            $table->text('alamat');
            $table->foreignId('bidang_minat_id')->constrained()->onDelete('CASCADE');
            $table->string('kompetensi');
            $table->string('file_ktp');
            $table->string('file_khs');
            $table->string('file_prasyarat');
            $table->string('apsi_semester');
            $table->integer('apsi_nilai');
            $table->string('manpro_semester');
            $table->integer('manpro_nilai');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
