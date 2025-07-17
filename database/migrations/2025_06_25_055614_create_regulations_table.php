<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Regulation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $status = Regulation::STATUS;
        Schema::create('regulations', function (Blueprint $table) use ($status) {
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
        Schema::dropIfExists('regulations');
    }
};
