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
        Schema::table('tenders', function (Blueprint $table) {
            $table->unsignedBigInteger('project_details')->nullable()->after('type_of_contracting');
            $table->unsignedBigInteger('pd_beneficiary')->nullable()->after('project_details');
            $table->string('pd_project_name')->nullable()->after('pd_beneficiary');
            $table->text('pd_project_description')->nullable()->after('pd_project_name');
            $table->unsignedDecimal('pd_project_value', 18, 0)->nullable()->after('pd_project_description');
            $table->unsignedBigInteger('pd_type_of_project')->nullable()->after('pd_project_value');
            $table->date('pd_project_start_date')->nullable()->after('pd_type_of_project');
            $table->date('pd_project_end_date')->nullable()->after('pd_project_start_date');
            $table->unsignedBigInteger('pd_period_of_project')->nullable()->after('pd_project_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn(['project_details', 'pd_beneficiary', 'pd_project_name', 'pd_project_description', 'pd_project_value', 'pd_type_of_project', 'pd_project_start_date', 'pd_project_end_date', 'pd_period_of_project']);
        });
    }
};
