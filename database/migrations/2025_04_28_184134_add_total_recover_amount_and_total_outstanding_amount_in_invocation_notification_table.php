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
            $table->unsignedDecimal('total_recoverd_amount',18,0)->default(0)->after('invocation_amount');
            $table->unsignedDecimal('total_outstanding_amount',18,0)->default(0)->after('total_recoverd_amount');
            $table->unsignedDecimal('claimed_amount',18,0)->nullable()->after('total_outstanding_amount');
            $table->unsignedDecimal('disallowed_amount',18,0)->nullable()->after('claimed_amount');
            $table->unsignedDecimal('total_approved_bond_value',18,0)->nullable()->after('disallowed_amount');
            $table->longText('payout_remark')->nullable()->after('remark');
            $table->string('status')->default('Pending')->nullable()->after('remark');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->dropColumn([
                'total_recoverd_amount',
                'total_outstanding_amount',
                'claimed_amount',
                'disallowed_amount',
                'total_approved_bond_value',
                'payout_remark',
                'status'
            ]);
        });
    }
};
