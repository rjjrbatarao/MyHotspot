<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatellitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satellites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->string('status')->default('down');//options down idle charging active
            $table->string('status_main')->default('unassigned');
            $table->string('mode')->default('remote'); // main or remote // there can be only one main
            $table->string('btntext')->default('Autologin');
            $table->boolean('enable_time')->default(true);//toggle
            $table->integer('timeprofile_id')->unsigned()->nullable();
            $table->boolean('enable_data')->default(true);//toggle
            $table->integer('dataprofile_id')->unsigned()->nullable();
            $table->boolean('enable_charging')->default(true);// toggle
            $table->integer('chargeprofile_id')->unsigned()->nullable();
            $table->integer('pinprofile_id')->unsigned();
            $table->integer('service_default')->unsigned()->default(0);
            $table->integer('package_default')->unsigned()->default(0);
            $table->boolean('enable_generate')->default(true);//enable generate voucher
            $table->string('btncolor')->default('#009688');
            $table->integer('progress_time')->default(60)->unsigned();
            $table->ipAddress('ip')->nullable();// subvendo ip address to fetch automatically
            $table->ipAddress('mac')->nullable();// subvendo mac address to fetch automatically used for binding security
            $table->boolean('enable_billacceptor')->default(false);
            $table->boolean('enable_thermalprinter')->default(false);
            //$table->ipAddress('gateway')->nullable();
            $table->integer('insert_timeout')->unsigned()->default(30);
            $table->string('redirect_after')->nullable();// redirect after login            
            $table->string('firmware')->nullable(); // firmware version
            $table->string('device')->nullable(); // device type arduino uno/ mega ,esp32/8n66 etc
            $table->string('token');// auto generate api token key
            $table->string('key');// auto generate secure encryption key
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satellites');
    }
}
