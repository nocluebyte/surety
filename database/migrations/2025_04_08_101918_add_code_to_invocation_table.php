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
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->string('code')->nullable()->after('id');
        });
        Schema::table('invocation_claims', function (Blueprint $table) {
            $table->string('code')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->dropColumn('code');
        });
        Schema::table('invocation_claims', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
