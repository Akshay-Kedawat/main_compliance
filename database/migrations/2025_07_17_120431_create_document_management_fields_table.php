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
        Schema::create('document_management_fields', function (Blueprint $table) {
            // 📌 Document Management Fields
            $table->integer('_createdby_editor_id')->nullable();
            $table->dateTime('_date_added')->useCurrent();
            $table->integer('_modifiedby_editor_id')->nullable();
            $table->dateTime('_date_modified')->nullable();
            $table->integer('_approvedby_editor_id')->nullable();
            $table->dateTime('_date_approved')->nullable();
            $table->boolean('_is_current_version')->default(true);
            $table->integer('_version_number')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_management_fields');
    }
};
