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
        Schema::create('resource_forms', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // soa, gtc, pod
            $table->string('subcategory')->nullable(); // e.g., 'Organization Forms', 'Activity Forms'
            $table->string('name');
            $table->string('template_filename')->nullable();
            $table->string('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_forms');
    }
};
