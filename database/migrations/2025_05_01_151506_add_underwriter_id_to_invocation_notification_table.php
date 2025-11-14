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
            $table->unsignedBigInteger('underwriter_id')->after('bond_type_id')->nullable();
            $table->unsignedBigInteger('cancellelation_reason_id')->nullable()->after('payout_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->dropColumn([
                'underwriter_id',
                'cancellelation_reason_id'
            ]);
        });
    }
};
