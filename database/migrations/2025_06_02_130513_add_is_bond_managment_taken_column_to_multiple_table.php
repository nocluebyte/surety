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
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
              $table->tinyInteger('is_bond_managment_action_taken')->default(0)->after('is_current');
              $table->string('bond_managment_action_type')->after('is_bond_managment_action_taken')->nullable();

              
        });

        Schema::table('cases_decisions', function (Blueprint $table) {
              $table->tinyInteger('is_bond_managment_action_taken')->default(0)->after('is_amendment');
               $table->string('bond_managment_action_type')->after('is_bond_managment_action_taken')->nullable();
        });

        Schema::table('cases', function (Blueprint $table) {
              $table->tinyInteger('is_bond_managment_action_taken')->default(0)->after('is_amendment');
               $table->string('bond_managment_action_type')->after('is_bond_managment_action_taken')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->dropColumn([
                'is_bond_managment_action_taken',
                'bond_managment_action_type'
            ]);
        });

        Schema::table('cases_decisions', function (Blueprint $table) {
            $table->dropColumn([
                'is_bond_managment_action_taken',
                'bond_managment_action_type'
            ]);
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn([
                'is_bond_managment_action_taken',
                'bond_managment_action_type'
            ]);
        });
    }
};
