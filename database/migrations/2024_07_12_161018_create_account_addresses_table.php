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
        Schema::create('account_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('account_id')->constrained();
            $table->enum('address_type', ['office', 'factory']);
            $table->string('address_line1', 200);
            $table->string('address_line2', 200)->nullable();
            $table->string('mobile', 15);
            $table->string('mobile2', 15)->nullable();
            $table->string('phone', 15)->nullable();;
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->string('city', 100);
            $table->string('pincode', 6)->nullable();
            $table->string('distance', 10)->nullable();
            $table->enum('gst_type', ['Registered', 'Un-registered', 'Composition'])->default('Un-registered');
            $table->string('gst_no', 20)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_addresses');
    }
};
