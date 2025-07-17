<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role = Role::ROLE_TYPE;

        Schema::table('roles', function (Blueprint $table) use($role) {
            $table->tinyInteger('is_primary')->default(0)->after('guard_name')
            ->comment($role['Primary'].'=Primary,'.$role['Not Primary'].'=Not Primary')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_primary');
        });
    }
};
