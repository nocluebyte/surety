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
            $table->dropColumn(['description', 'principal_name', 'estimated_date_of_completion', 'type_of_project_track', 'project_share_track', 'amount_margin', 'completion_status']);

            $table->text('project_description')->nullable()->after('project_cost');
            $table->date('project_end_date')->nullable()->after('project_start_date');
            $table->text('bank_guarantees_details')->nullable()->after('actual_date_completion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_track_records', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('principal_name')->nullable();
            $table->date('estimated_date_of_completion')->nullable();
            $table->unsignedBigInteger('type_of_project_track')->nullable();
            $table->unsignedDecimal('project_share_track', 18, 0)->nullable();
            $table->unsignedDecimal('amount_margin', 18, 0)->nullable();
            $table->string('completion_status')->nullable();

            $table->dropColumn(['project_description', 'project_end_date', 'bank_guarantees_details']);
        });
    }
};
