<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resource_forms', function (Blueprint $table) {
            if (!Schema::hasColumn('resource_forms', 'category')) {
                $table->string('category')->after('id');
            }
            if (!Schema::hasColumn('resource_forms', 'subcategory')) {
                $table->string('subcategory')->nullable()->after('category');
            }
            if (!Schema::hasColumn('resource_forms', 'name')) {
                $table->string('name')->after('subcategory');
            }
            if (!Schema::hasColumn('resource_forms', 'template_filename')) {
                $table->string('template_filename')->nullable()->after('name');
            }
            if (!Schema::hasColumn('resource_forms', 'display_order')) {
                $table->integer('display_order')->default(0)->after('template_filename');
            }
            if (!Schema::hasColumn('resource_forms', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('display_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('resource_forms', function (Blueprint $table) {
            $table->dropColumn(['category', 'subcategory', 'name', 'template_filename', 'display_order', 'is_active']);
        });
    }
};
