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
        Schema::table('project_track_records', function (Blueprint $table) {
            $table->renameColumn('proposal_id','projecttrackrecordsable_id');
            $table->string('projecttrackrecordsable_type')->after('id');
        });
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
