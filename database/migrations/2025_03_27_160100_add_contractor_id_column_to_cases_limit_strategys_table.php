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
        Schema::table('cases_limit_strategys', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases_limit_strategys', function (Blueprint $table) {
            $table->dropColumn('contractor_id');
        });
    }
};
