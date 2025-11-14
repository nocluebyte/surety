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
            $table->renameColumn('proposal_id','orderbookandfutureprojectsable_id');
            $table->string('orderbookandfutureprojectsable_type')->after('id');
        });
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
