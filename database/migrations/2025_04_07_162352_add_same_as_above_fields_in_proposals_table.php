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
            $table->enum('contractor_same_as_above', ['Yes', 'No'])->default('No')->after('contractor_mobile');
            $table->text('contractor_bond_address')->nullable()->after('contractor_same_as_above');
            $table->unsignedBigInteger('contractor_bond_country_id')->nullable()->after('contractor_bond_address');
            $table->unsignedBigInteger('contractor_bond_state_id')->nullable()->after('contractor_bond_country_id');
            $table->string('contractor_bond_city')->nullable()->after('contractor_bond_state_id');
            $table->string('contractor_bond_pincode')->nullable()->after('contractor_bond_city');
            $table->string('contractor_bond_gst_no')->nullable()->after('contractor_bond_pincode');

            $table->enum('beneficiary_same_as_above', ['Yes', 'No'])->default('No')->after('ministry_type_id');
            $table->text('beneficiary_bond_address')->nullable()->after('beneficiary_same_as_above');
            $table->unsignedBigInteger('beneficiary_bond_country_id')->nullable()->after('beneficiary_bond_address');
            $table->unsignedBigInteger('beneficiary_bond_state_id')->nullable()->after('beneficiary_bond_country_id');
            $table->string('beneficiary_bond_city')->nullable()->after('beneficiary_bond_state_id');
            $table->string('beneficiary_bond_pincode')->nullable()->after('beneficiary_bond_city');
            $table->string('beneficiary_bond_gst_no')->nullable()->after('beneficiary_bond_pincode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn([
                'contractor_same_as_above',
                'contractor_bond_address',
                'contractor_bond_country_id',
                'contractor_bond_state_id',
                'contractor_bond_city',
                'contractor_bond_pincode',
                'contractor_bond_gst_no',

                'beneficiary_same_as_above',
                'beneficiary_bond_address',
                'beneficiary_bond_country_id',
                'beneficiary_bond_state_id',
                'beneficiary_bond_city',
                'beneficiary_bond_pincode',
                'beneficiary_bond_gst_no',
            ]);
        });
    }
};
