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
        Schema::table('nbis', function (Blueprint $table) {
            $table->string('indemnity_letter_type')->nullable()->after('bond_wording');
            $table->string('indemnity_letter_document')->nullable()->after('indemnity_letter_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            $table->dropColumn([
                'indemnity_letter_type',
            ]);
        });
    }
};
