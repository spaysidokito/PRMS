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
        Schema::create('resource_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('form_type'); // 'soa', 'gtc', 'pod'
            $table->string('form_name')->nullable(); // template name or uploaded file name
            $table->enum('action', ['view', 'download', 'preview', 'upload']); // action performed
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('file_path')->nullable(); // path to the file accessed
            $table->timestamps();

            $table->index(['form_type', 'action']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_access_logs');
    }
};
