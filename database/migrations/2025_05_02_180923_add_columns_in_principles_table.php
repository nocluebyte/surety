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
            $table->date('inception_date')->nullable()->after('date_of_incorporation');
            $table->unsignedBigInteger('entity_type_id')->nullable()->after('inception_date');
            $table->unsignedInteger('staff_strength')->nullable()->after('entity_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['inception_date', 'entity_type_id', 'staff_strength']);
        });
    }
};
