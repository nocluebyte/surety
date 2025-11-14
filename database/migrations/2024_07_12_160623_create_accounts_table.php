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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('slug')->nullable();
            $table->string('person_name');
            $table->string('email', 255)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('category', 25)->nullable();
            $table->enum('object_type', ['Supplier', 'Customer']);
            $table->integer('user_id')->default(0);
            $table->decimal('opening', 16, 2)->nullable();
            $table->string('opening_type', 50)->nullable();;
            $table->integer('credit_days')->default(0);
            $table->decimal('credit_limit', 13, 2)->nullable();
            $table->enum('is_approved', ['Yes', 'No'])->default('No');
            $table->enum('factory_close_on', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])->default('Sunday');
            $table->enum('is_notified', ['Yes', 'No'])->default('No');
            $table->integer('unit_id')->default(1);
            $table->decimal('depreciation_per', 8, 2)->nullable();
            $table->integer('depreciation_account_id')->default(0);
            $table->decimal('interest_per', 8, 2)->nullable();
            $table->integer('interest_account_id')->nullable();
            $table->enum('interest_type', ['CR', 'DR'])->default('DR');
            $table->string('supplier_type')->nullable();
            $table->integer('managed_by')->nullable();
            $table->integer('secondary_managed_by')->nullable();
            $table->integer('category_segment_id')->default(0);
            $table->unsignedBigInteger('parent_account_id')->nullable();
            $table->foreign('parent_account_id')->references('id')->on('accounts');
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
            $table->integer('payment_due_day')->nullable();
            $table->enum('is_check_factory_address', [0, 1])->default(0);
            $table->string('ip')->nullable();
            $table->string('update_from_ip')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
