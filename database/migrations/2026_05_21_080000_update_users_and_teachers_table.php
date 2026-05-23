<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'teacher' to the role enum
            $table->enum('role', ['admin', 'staff', 'student', 'teacher'])->default('admin')->change();
        });

        Schema::table('teachers', function (Blueprint $table) {
            // Link teachers to users table
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff', 'student'])->default('admin')->change();
        });
    }
};
