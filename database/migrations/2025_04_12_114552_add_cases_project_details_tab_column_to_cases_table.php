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
        Schema::table('cases', function (Blueprint $table) {
            $table->longText('project_details_current_status_of_the_project')->nullable()
            ->after('cases_action_blacklisted_contractor_remark');
            $table->longText('project_details_any_updates')
            ->after('project_details_current_status_of_the_project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn([
                'project_details_current_status_of_the_project',
                'project_details_any_updates'
            ]);
        });
    }
};
