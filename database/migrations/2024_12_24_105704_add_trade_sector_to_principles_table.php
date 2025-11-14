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
            $table->unsignedBigInteger('trade_sector')->nullable()->after('gst_no');
            $table->date('inception_date')->nullable()->after('date_of_incorporation');
            $table->string('website')->nullable()->after('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['trade_sector', 'inception_date', 'website']);
        });
    }
};
