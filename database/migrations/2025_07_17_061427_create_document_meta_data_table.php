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
        Schema::create('document_meta_data', function (Blueprint $table) {
            $table->string('_idext_document', 100)->primary()->index();
            $table->string('_type_document', 255)->nullable()->index();
            $table->string('_type_subdivision', 255)->nullable();
            $table->string('_local_identifier', 100)->nullable();
            $table->string('_sortable_identifier', 100)->nullable();
            $table->date('_date_document')->nullable();
            $table->date('_date_publication')->nullable();
            $table->string('_number', 50)->nullable();
            $table->integer('_year')->nullable();
            $table->date('_date_latest_update')->nullable();
            $table->string('_latest_update', 100)->nullable();
            $table->string('_legal_value', 255)->nullable();
            $table->string('_in_force', 100)->nullable();
            $table->string('_publisher', 255)->nullable();
            $table->string('_jurisdiction_federal', 255)->nullable();
            $table->string('_jurisdiction_regional', 255)->nullable();
            $table->string('_jurisdiction_local', 255)->nullable();
            $table->date('_first_date_entry_in_force')->nullable();
            $table->date('_date_no_longer_in_force')->nullable();
            $table->integer('_crc32_pipeline_checksum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_meta_data');
    }
};
