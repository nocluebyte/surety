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
        Schema::table('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('beneficiary_country_id')->nullable()->after('beneficiary_website');
            $table->unsignedBigInteger('beneficiary_state_id')->nullable()->after('beneficiary_country_id');
            $table->enum('is_spv', ['Yes', 'No'])->default('No')->after('are_you_blacklisted');
            $table->string('tender_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['beneficiary_country_id', 'beneficiary_state_id', 'is_spv']);
            $table->unsignedBigInteger('tender_id')->nullable()->change();
        });
    }
};
