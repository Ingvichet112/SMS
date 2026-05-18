<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// បង្កើតតារាង school_classes សម្រាប់រក្សាទុកព័ត៌មានថ្នាក់រៀន
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            // ឈ្មោះថ្នាក់
            $table->string('class_name');
            // លេខបន្ទប់
            $table->string('room_number')->nullable();
            // Foreign key ភ្ជាប់ទៅគ្រូ (គ្រូ ១ មានថ្នាក់ច្រើន)
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
