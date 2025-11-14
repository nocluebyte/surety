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
        Schema::table('issuing_office_branches', function (Blueprint $table) {
            $table->string('branch_code')->nullable()->after('branch_name');

            $table->dropColumn(['cin_no', 'sac_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issuing_office_branches', function (Blueprint $table) {
            $table->dropColumn('branch_code');

            $table->string('cin_no')->nullable()->after('city');
            $table->string('sac_code')->nullable()->after('gst_no');
        });
    }
};
