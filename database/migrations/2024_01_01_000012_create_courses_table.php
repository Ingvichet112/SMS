<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// បង្កើតតារាង courses សម្រាប់រក្សាទុកព័ត៌មានមុខវិជ្ជា
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // លេខកូដមុខវិជ្ជា
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->text('description')->nullable();
            // ចំនួនក្រេឌីត
            $table->integer('credit')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
