<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Question;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $type = Question::TYPE;
        Schema::create('questions', function (Blueprint $table) use ($type) {
            $table->id();
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->string('question')->nullable()->index();
            $table->enum('type', [$type['single-choice'], $type['multiple-choice'], $type['short-answer'], $type['true-false']])->nullable()->index();
            $table->json('options')->nullable();
            $table->string('answer')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
