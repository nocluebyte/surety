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
        Schema::table('blacklists', function (Blueprint $table) {
            $table->string('source')->nullable()->after('contractor_id');
            $table->date('blacklist_date')->nullable()->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blacklists', function (Blueprint $table) {
            $table->dropColumn(['source', 'blacklist_date']);
        });
    }
};
