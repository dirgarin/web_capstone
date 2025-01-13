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
        Schema::create('tims', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ketua');
            $table->foreignId('mahasiswa1_id')->constrained('mahasiswas')->onDelete('CASCADE');
            $table->foreignId('mahasiswa2_id')->constrained('mahasiswas')->onDelete('CASCADE');
            $table->foreignId('mahasiswa3_id')->constrained('mahasiswas')->onDelete('CASCADE');
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
        Schema::dropIfExists('tims');
    }
};
