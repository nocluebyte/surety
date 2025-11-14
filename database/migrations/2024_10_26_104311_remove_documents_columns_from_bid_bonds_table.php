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
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn(['certificate_of_incorporation', 'memorandum_and_articles', 'company_pan_no', 'gst_certificate', 'bond_wording_file']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            //
        });
    }
};
