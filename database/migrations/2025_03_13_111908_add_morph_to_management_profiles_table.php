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
        Schema::table('management_profiles', function (Blueprint $table) {
            $table->renameColumn('proposal_id','managementprofilesable_id');
            $table->string('managementprofilesable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('management_profiles', function (Blueprint $table) {
            //
        });
    }
};
