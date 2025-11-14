<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('emp_type')->nullable()->after('last_name');
            $table->bigInteger('emp_id')->nullable()->after('emp_type');           
            $table->string('mobile')->nullable()->after('emp_id');
            $table->unsignedInteger('roles_id')->nullable()->after('mobile');
            $table->foreign('roles_id')->references('id')->on('roles');            
            $table->string('image')->nullable()->after('roles_id');
            $table->string('image_path')->nullable()->after('image');
            $table->enum('is_active',['Yes','No'])->default('No')->after('image_path');
            $table->enum('is_ip_base',['Yes','No'])->default('No')->after('is_active');
            $table->text('ip')->nullable()->after('is_ip_base');
            $table->tinyInteger('allow_multi_login')->default('0')->after('is_ip_base');
            $table->text('update_from_ip')->nullable()->after('ip');
            $table->integer('created_by')->nullable()->after('update_from_ip');
            $table->integer('updated_by')->nullable()->after('created_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('emp_type');
            $table->dropColumn('emp_id');
            $table->dropForeign(['location_id']);
            $table->dropColumn(['location_id']);
            $table->dropColumn('mobile');
            $table->dropForeign(['roles_id']);
            $table->dropColumn(['roles_id']);
            $table->dropColumn('image');
            $table->dropColumn('image_path');
            $table->dropColumn('is_active');
            $table->dropColumn('is_ip_base');
            $table->dropColumn('allow_multi_login');
            $table->dropColumn('ip');
            $table->dropColumn('update_from_ip');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
