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
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->integer('version')->default(0)->after('code');
            $table->string('status')->nullable()->after('relevant_other_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('version');
            $table->dropColumn('status');
        });
    }
};
