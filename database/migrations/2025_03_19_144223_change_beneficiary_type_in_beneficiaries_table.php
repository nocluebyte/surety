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
        DB::statement("ALTER TABLE beneficiaries CHANGE COLUMN beneficiary_type beneficiary_type ENUM('Government', 'Non-Government') DEFAULT NULL");

        DB::statement("ALTER TABLE beneficiaries CHANGE COLUMN type_of_beneficiary_entity type_of_beneficiary_entity BIGINT UNSIGNED DEFAULT NULL");

        DB::statement("ALTER TABLE beneficiaries CHANGE COLUMN establishment_type_id establishment_type_id BIGINT UNSIGNED DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE beneficiaries CHANGE COLUMN beneficiary_type beneficiary_type ENUM('Public', 'Private') NOT NULL DEFAULT 'Public'");

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->integer('type_of_beneficiary_entity')->default(0)->change();
            $table->integer('establishment_type_id')->default(0)->change();
        });
    }
};
