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
        Schema::rename('principle_contact_details','contact_details');
        Schema::table('contact_details', function (Blueprint $table) {
            $table->renameColumn('principle_id','contactdetailsable_id');
            $table->string('contactdetailsable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_details', function (Blueprint $table) {
            //
        });
    }
};
