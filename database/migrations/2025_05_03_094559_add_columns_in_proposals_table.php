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
            $table->date('contractor_inception_date')->nullable()->after('contractor_bond_gst_no');
            $table->unsignedBigInteger('contractor_entity_type_id')->nullable()->after('contractor_inception_date');
            $table->unsignedInteger('contractor_staff_strength')->nullable()->after('contractor_entity_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['contractor_inception_date', 'contractor_entity_type_id', 'contractor_staff_strength']);
        });
    }
};
