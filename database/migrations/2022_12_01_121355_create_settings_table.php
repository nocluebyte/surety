<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('value')->nullable();
            $table->string('group')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $settingData = [
            [
                'name' => 'project_title',
                'title' => 'Project Title',
                'value' => 'Nsure Surety',
                'group' => 'company',
            ],
            [
                'name' => 'company_name',
                'title' => 'Company Name',
                'value' => 'Nsure Surety',
                'group' => 'company',
            ],
            [
                'name' => 'company_address',
                'title' => 'Company Address',
                'value' => 'Dubai',
                'group' => 'company',
            ],
            [
                'name' => 'gst_no',
                'title' => 'GST No',
                'value' => '24ABDCS3035J1ZH',
                'group' => 'company',
            ],
            [
                'name' => 'pan_no',
                'title' => 'PAN No',
                'value' => 'ABDCS3035J',
                'group' => 'company',
            ],
            [
                'name' => 'country',
                'title' => 'Country',
                'value' => '',
                'group' => 'company',
            ],
            [
                'name' => 'state',
                'title' => 'State',
                'value' => '',
                'group' => 'company',
            ],
            [
                'name' => 'city',
                'title' => 'City',
                'value' => '',
                'group' => 'company',
            ],
            [
                'name' => 'pincode',
                'title' => 'Pincode',
                'value' => '',
                'group' => 'company',
            ],
        ];

        DB::table('settings')->insert($settingData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
