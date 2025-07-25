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

        Schema::create('document_forms', function (Blueprint $table) {
            $table->string('_idext_document', 100)->primary();
            $table->string('_form_descriptor', 50)->nullable();
            $table->string('_url', 512);
            $table->string('_content_format', 50)->nullable();
            $table->string('_language', 5);
            $table->integer('_crc32_checksum')->nullable();

            // Common fields
            $table->integer('_createdby_editor_id')->nullable();
            $table->dateTime('_date_added')->useCurrent();
            $table->integer('_modifiedby_editor_id')->nullable();
            $table->dateTime('_date_modified')->nullable();
            $table->integer('_approvedby_editor_id')->nullable();
            $table->dateTime('_date_approved')->nullable();
            $table->boolean('_is_current_version')->default(1);
            $table->integer('_version_number')->default(1);
        });
        // Add indexes
        Schema::table('document_forms', function (Blueprint $table) {
            $table->index('_idext_document');
            $table->index('_form_descriptor');
            $table->index('_url');
            $table->index('_content_format');
            $table->index('_language');
            $table->index('_createdby_editor_id');
            $table->index('_date_added');
            $table->index('_modifiedby_editor_id');
            $table->index('_date_modified');
            $table->index('_approvedby_editor_id');
            $table->index('_date_approved');
            $table->index('_is_current_version');
            $table->index('_version_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_forms');
    }
};
