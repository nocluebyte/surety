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
            $table->dropColumn('beneficiary_name');
            $table->enum('is_manual_entry', ['Yes', 'No'])->default('Yes')->after('networth');
            $table->integer('beneficiary_id')->default(0)->after('is_manual_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('beneficiary_id');
            $table->dropColumn('is_manual_entry');
            $table->string('beneficiary_name')->nullable()->after('is_manual_entry');
        });
    }
};
