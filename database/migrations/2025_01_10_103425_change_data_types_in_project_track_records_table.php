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
        DB::statement("ALTER TABLE project_track_records CHANGE `project_cost` `project_cost` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE project_track_records CHANGE `project_tenor` `project_tenor` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE project_track_records CHANGE `project_share_track` `project_share_track` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE project_track_records CHANGE `amount_margin` `amount_margin` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE project_track_records CHANGE `bg_amount` `bg_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");

        DB::statement("ALTER TABLE project_track_records CHANGE `proposal_id` `proposal_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE project_track_records CHANGE `type_of_project_track` `type_of_project_track` BIGINT UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_track_records', function (Blueprint $table) {
            //
        });
    }
};
