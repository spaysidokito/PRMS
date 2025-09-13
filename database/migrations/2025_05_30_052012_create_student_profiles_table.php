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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date');
            $table->string('gender');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('course');
            $table->string('year_level');
            $table->string('section');
            $table->string('status')->default('active'); // e.g., active, inactive, graduated, dropped
            $table->text('emergency_contact')->nullable(); // Consider JSON for structured data
            $table->text('medical_information')->nullable(); // Consider JSON for structured data
            $table->string('department_cluster'); // e.g., SBAT, SEAS, SHTM, SNAMS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
