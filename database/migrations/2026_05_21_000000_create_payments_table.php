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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(150.00);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('paid');
            $table->string('payment_method')->nullable(); // ABA, Cash, Wing, etc.
            $table->string('semester')->default('Semester 1');
            $table->string('academic_year')->default('2023-2024');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
