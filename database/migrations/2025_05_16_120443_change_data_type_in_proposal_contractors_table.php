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
        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->unsignedDecimal('jv_spv_exposure', 18, 0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->integer('jv_spv_exposure')->nullable()->change();
        });
    }
};
