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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedDecimal('max_approved_limit',18,0)->nullable()->after('image_path');
            $table->unsignedDecimal('individual_cap',18,0)->nullable()->after('max_approved_limit');
            $table->unsignedDecimal('overall_cap',18,0)->nullable()->after('individual_cap');
            $table->unsignedDecimal('group_cap',18,0)->nullable()->after('overall_cap');
             $table->tinyInteger('is_created_directly')->nullable()->after('group_cap');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'max_approved_limit',
                'individual_cap',
                'overall_cap',
                'group_cap',
                'is_created_directly'
            ]);
        });
    }
};
