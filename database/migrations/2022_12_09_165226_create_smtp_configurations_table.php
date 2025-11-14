<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtpConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('module_name')->nullable();
                $table->string('from_name')->nullable();
                $table->string('host_name')->nullable();
                $table->string('username')->nullable();
                $table->string('port')->nullable();
                $table->string('password')->nullable();
                $table->string('driver')->nullable();
                $table->string('encryption')->nullable();
                $table->enum('is_active', ['Yes', 'No'])->default('Yes');
                $table->string('ip')->nullable();
                $table->string('update_from_ip')->nullable();
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->softDeletes();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smtp_configurations');
    }
}
