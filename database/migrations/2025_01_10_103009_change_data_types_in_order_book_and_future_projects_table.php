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
        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `contract_value` `contract_value` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `tenure` `tenure` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `project_share` `project_share` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `guarantee_amount` `guarantee_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");

        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `proposal_id` `proposal_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE order_book_and_future_projects CHANGE `type_of_project` `type_of_project` BIGINT UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_book_and_future_projects', function (Blueprint $table) {
            //
        });
    }
};
