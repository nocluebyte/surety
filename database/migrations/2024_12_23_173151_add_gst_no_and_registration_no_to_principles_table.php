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
        Schema::table('principles', function (Blueprint $table) {
            $table->string('gst_no')->nullable()->after('pan_no');
            $table->string('registration_no')->nullable()->after('company_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['gst_no', 'registration_no']);
        });
    }
};
