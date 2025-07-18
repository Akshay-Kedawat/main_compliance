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
        Schema::create('document_languages', function (Blueprint $table) {
            $table->id();
            $table->string('_idext_document', 100)->nullable()->index();
            $table->string('_language', 5)->nullable()->index();
            $table->string('_title', 255)->nullable()->index();
            $table->string('_title_alternative', 255)->nullable();
            $table->string('_title_short', 255)->nullable();
            $table->integer('_crc32_checksum')->nullable();
            $table->text('response_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_languages');
    }
};
