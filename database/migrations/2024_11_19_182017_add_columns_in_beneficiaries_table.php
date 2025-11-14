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
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->enum('beneficiary_type', ['Public', 'Private'])->nullable()->after('last_name');
            $table->integer('type_of_beneficiary_entity')->default(0)->after('beneficiary_type');
            $table->integer('establishment_type_id')->default(0)->after('type_of_beneficiary_entity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn('beneficiary_type');
            $table->dropColumn('type_of_beneficiary_entity');
            $table->dropColumn('establishment_type_id');
        });
    }
};
