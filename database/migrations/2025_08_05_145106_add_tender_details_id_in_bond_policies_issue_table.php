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
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->unsignedBigInteger('tender_details_id')->nullable()->after('tender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->dropColumn('tender_details_id');
        });
    }
};
