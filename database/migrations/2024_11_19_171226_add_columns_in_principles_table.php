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
            $table->date('date_of_incorporation')->nullable()->after('last_name');
            $table->integer('type_of_entity_id')->default(0)->after('date_of_incorporation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn('date_of_incorporation');
            $table->dropColumn('type_of_entity_id');
        });
    }
};
