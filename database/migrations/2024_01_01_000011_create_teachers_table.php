<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// បង្កើតតារាង teachers សម្រាប់រក្សាទុកព័ត៌មានគ្រូ
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            // លេខសម្គាល់គ្រូ (ប្រើក្នុងប្រព័ន្ធ)
            $table->string('teacher_id')->unique();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            // មុខវិជ្ជាដែលគ្រូបង្រៀន
            $table->string('subject');
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
