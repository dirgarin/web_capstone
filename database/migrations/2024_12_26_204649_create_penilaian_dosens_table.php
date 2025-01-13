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
        Schema::create('penilaian_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_dokumen_id')->constrained('mahasiswa_dokumens')->onDelete('CASCADE');
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('CASCADE');
            $table->integer('nilai');
            $table->text('feedback');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_dosens');
    }
};
