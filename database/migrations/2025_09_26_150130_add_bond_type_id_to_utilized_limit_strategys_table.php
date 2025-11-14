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
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->unsignedBigInteger('bond_type_id')->nullable()->after('cases_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->dropColumn([
                'bond_type_id'
            ]);
        });
    }
};
