<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // បន្ថែម 'student' ទៅក្នុង enum role
            $table->enum('role', ['admin', 'staff', 'student'])->default('admin')->change();
        });

        Schema::table('students', function (Blueprint $table) {
            // ភ្ជាប់សិស្សទៅនឹង User account
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->default('admin')->change();
        });
    }
};
