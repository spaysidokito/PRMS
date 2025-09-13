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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('venue');
            $table->string('type'); // social, academic, training, etc.
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed, cancelled
            $table->integer('max_participants')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->json('requirements')->nullable(); // specific event requirements
            $table->json('attachments')->nullable(); // documents, images, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
