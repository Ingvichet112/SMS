<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// បង្កើតតារាង students សម្រាប់រក្សាទុកព័ត៌មានសិស្ស
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // លេខសម្គាល់សិស្ស (ប្រើក្នុងប្រព័ន្ធ)
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            // ថ្ងៃខែឆ្នាំកំណើត
            $table->date('date_of_birth')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            // Foreign key ភ្ជាប់ទៅថ្នាក់ (សិស្ស ១ នៅក្នុងថ្នាក់ ១)
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->nullOnDelete();
            // រូបថតសិស្ស
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
