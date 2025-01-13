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
        Schema::create('mahasiswa_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('CASCADE');
            $table->foreignId('daftar_topik_id')->constrained('daftar_topiks')->onDelete('CASCADE');
            $table->foreignId('template_id')->constrained('templates')->onDelete('CASCADE');
            $table->string('file_dokumen');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_dokumens');
    }
};
