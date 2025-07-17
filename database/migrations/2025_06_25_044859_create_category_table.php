<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $status = Category::STATUS;

        Schema::create('category', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('name')->nullable()->index();
            $table->tinyInteger('status')->default($status['Inactive'])->comment($status['Inactive'] . '=Inactive,' . $status['Active'] . '=Active')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
