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
        Schema::create('topik_mandiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('judul');
            $table->string('instansi');
            $table->string('deskripsi');
            $table->enum('status', ['pending', 'approved', 'assigned', 'rejected'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_mandiris');
    }
};
