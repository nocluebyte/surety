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
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('pan_details')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_ckyc_no')->nullable();
            $table->text('register_address')->nullable();
            $table->string('parent_group')->nullable();
            $table->date('date_of_incorporation')->nullable();
            $table->string('authorized_capital')->nullable();
            $table->text('applicant_business_activity')->nullable();
            $table->date('certification_state_date')->nullable();
            $table->date('agency_rating_date')->nullable();
            $table->text('agency_rating_detail')->nullable();
            $table->string('chairman_name')->nullable();
            $table->string('chairman_address')->nullable();
            $table->string('chairman_shares')->nullable();
            $table->integer('individual_networth')->default(0);
            $table->tinyInteger('is_confirm_pep')->default(0);
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('ip')->nullable();
            $table->string('update_from_ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
