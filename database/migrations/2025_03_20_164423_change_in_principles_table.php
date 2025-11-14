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
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['inception_date', 'type_of_entity_id']);

            $table->enum('are_you_blacklisted', ['Yes', 'No'])->nullable()->after('date_of_incorporation');
            $table->enum('is_bank_guarantee_provided', ['Yes', 'No'])->nullable()->after('rating_remarks');
            $table->text('circumstance_short_notes')->nullable()->after('is_bank_guarantee_provided');
            $table->enum('is_action_against_proposer', ['Yes', 'No'])->nullable()->after('circumstance_short_notes');
            $table->text('action_details')->nullable()->after('is_action_against_proposer');
            $table->text('contractor_failed_project_details')->nullable()->after('action_details');
            $table->text('completed_rectification_details')->nullable()->after('contractor_failed_project_details');
            $table->text('performance_security_details')->nullable()->after('completed_rectification_details');
            $table->text('relevant_other_information')->nullable()->after('performance_security_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->date('inception_date')->nullable();
            $table->integer('type_of_entity_id')->default(0);

            $table->dropColumn(['are_you_blacklisted', 'is_bank_guarantee_provided', 'circumstance_short_notes', 'is_action_against_proposer', 'action_details', 'contractor_failed_project_details', 'completed_rectification_details', 'performance_security_details', 'relevant_other_information']);
        });
    }
};
