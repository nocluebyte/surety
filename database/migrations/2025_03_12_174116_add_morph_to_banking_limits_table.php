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
        Schema::rename('proposal_banking_limits','banking_limits');
        Schema::table('banking_limits', function (Blueprint $table) {
            $table->renameColumn('proposal_id','bankinglimitsable_id');
            $table->string('bankinglimitsable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banking_limits', function (Blueprint $table) {
            //
        });
    }
};
