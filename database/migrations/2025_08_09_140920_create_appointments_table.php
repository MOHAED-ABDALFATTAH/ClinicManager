<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->time('time'); // slot start time
            $table->integer('duration')->default(30);
            $table->enum('status', ['pending_payment','scheduled','cancelled','completed'])->default('pending_payment');
            $table->boolean('is_paid')->default(false);
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id','date','time']);
        });
    }
    public function down() {
        Schema::dropIfExists('appointments');
    }
};
