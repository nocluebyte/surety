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
        Schema::table('adverse_informations', function (Blueprint $table) {
            $table->date('source_date')->nullable()->after('adverse_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adverse_informations', function (Blueprint $table) {
            $table->dropColumn('source_date');
        });
    }
};
