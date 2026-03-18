<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('weekday'); // 0 (Sun) .. 6 (Sat)
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_minutes')->default(30);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('doctor_schedules');
    }
};
