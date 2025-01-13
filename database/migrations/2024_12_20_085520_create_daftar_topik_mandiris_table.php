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
        Schema::create('daftar_topik_mandiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tims')->onDelete('CASCADE');
            $table->foreignId('topik_mandiri_id')->constrained()->onDelete('CASCADE');
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
        Schema::dropIfExists('daftar_topik_mandiris');
    }
};
