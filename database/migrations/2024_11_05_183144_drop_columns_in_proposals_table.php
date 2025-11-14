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
            $table->dropColumn(['pan_details', 'contact_person_name', 'contact_person_email', 'contact_person_designation', 'contact_person_phone', 'contact_person_ckyc_no', 'authorized_capital', 'applicant_business_activity', 'certification_state_date', 'agency_rating_detail', 'chairman_shares', 'individual_networth', 'is_confirm_pep']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            //
        });
    }
};
