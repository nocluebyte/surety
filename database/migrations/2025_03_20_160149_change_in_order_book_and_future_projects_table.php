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
        Schema::table('order_book_and_future_projects', function (Blueprint $table) {
            $table->dropColumn(['project_scope', 'project_location', 'type_of_project', 'contract_value', 'anticipated_date', 'tenure', 'principal_name']);

            $table->string('project_name')->nullable()->after('orderbookandfutureprojectsable_id');
            $table->unsignedDecimal('project_cost', 18, 0)->nullable()->after('project_name');
            $table->text('project_description')->nullable()->after('project_cost');
            $table->date('project_start_date')->nullable()->after('project_description');
            $table->date('project_end_date')->nullable()->after('project_start_date');
            $table->unsignedDecimal('project_tenor', 18, 0)->nullable()->after('project_end_date');
            $table->text('bank_guarantees_details')->nullable()->after('project_tenor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_book_and_future_projects', function (Blueprint $table) {
            $table->text('project_scope')->nullable();
            $table->string('project_location')->nullable();
            $table->unsignedBigInteger('type_of_project')->nullable();
            $table->unsignedDecimal('contract_value', 18, 0)->nullable();
            $table->date('anticipated_date')->nullable();
            $table->unsignedDecimal('tenure', 18, 0)->nullable();
            $table->string('principal_name')->nullable();

            $table->dropColumn(['project_cost', 'project_description', 'project_start_date', 'project_end_date', 'project_tenor', 'bank_guarantees_details']);
        });
    }
};
