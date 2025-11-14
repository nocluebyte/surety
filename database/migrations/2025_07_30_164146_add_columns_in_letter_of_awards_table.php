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
        Schema::table('letter_of_awards', function (Blueprint $table) {
            $table->dropColumn('parent_contractor_id');
            $table->unsignedBigInteger('beneficiary_id')->nullable()->after('contractor_id');
            $table->unsignedBigInteger('project_details_id')->nullable()->after('beneficiary_id');
            $table->unsignedBigInteger('tender_id')->nullable()->after('project_details_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_of_awards', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_contractor_id')->nullable()->after('id');
            $table->dropColumn([
                'beneficiary_id',
                'project_details_id',
                'tender_id',
            ]);
        });
    }
};
