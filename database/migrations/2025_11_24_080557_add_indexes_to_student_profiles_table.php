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
        Schema::table('student_profiles', function (Blueprint $table) {
            // Add indexes for frequently searched columns
            $table->index('student_id');
            $table->index('last_name');
            $table->index('first_name');
            $table->index('course');
            $table->index('department_cluster');
            $table->index('status');
            $table->index('year_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['last_name']);
            $table->dropIndex(['first_name']);
            $table->dropIndex(['course']);
            $table->dropIndex(['department_cluster']);
            $table->dropIndex(['status']);
            $table->dropIndex(['year_level']);
        });
    }
};
