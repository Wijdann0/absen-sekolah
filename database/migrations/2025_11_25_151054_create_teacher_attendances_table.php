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
    Schema::create('teacher_attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
        $table->date('date');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
        $table->time('check_in_time')->nullable();
        $table->time('check_out_time')->nullable();
        $table->text('note')->nullable();
        $table->timestamps();

        $table->unique(['teacher_id', 'date']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
    }
};
