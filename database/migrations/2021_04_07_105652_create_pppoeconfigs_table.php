<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePppoeconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pppoeconfigs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(); // service name
            $table->boolean('enable_radius')->default(true);// set radius as default manager
            $table->string('na_id')->nullable();// nas  
            $table->boolean('enable_ttl_1')->default(false);
            //ignore hotspot lanif if 
            $table->integer('adapter_id')->unsigned();//// doesnt matter which interface because of the protocol// lanif
            $table->ipAddress('local_ip')->nullable();
            $table->ipAddress('remote_ip')->nullable();// starting ip to assign
            $table->ipAddress('subnet_mask')->nullable(); // get total
            $table->integer('max_host')->unsigned(); //compute this using subnet mask
            $table->string('reminder_description')->nullable();
            $table->string('reminder_bgimage')->nullable();
            $table->boolean('enable_chat')->default(false);
            $table->string('reminder_text')->default('pay bills');
            $table->string('reminder_url')->nullable();// custom url for button, can be set from pppoe walled garden
            $table->string('reminder_css')->nullable();// style applied uploadable
            $table->boolean('enable_advertise')->default(false);
            $table->integer('advertise_interval')->unsigned()->default(3);
            $table->json('advertisements')->nullable();//upload as pictures
            $table->string('title')->default('Reminder');
            $table->string('footer')->default('Myhotspot');
            #poc 
            $table->boolean('enable_mikrotik')->default(false);// mikrotik cluster
            #hidden settings for reminder not significant
            $table->string('hs_lanif')->default('vlan200');//set vlan200 default when adapter id is same as hotspot adapter id
            $table->integer('hs_uamport')->unsigned();
            $table->integer('hs_uamuiport')->unsigned();
            $table->ipAddress('hs_network')->nullable();
            $table->ipAddress('hs_netmask')->nullable();
            $table->ipAddress('hs_uamlisten')->nullable();
            $table->ipAddress('hs_dns1')->nullable();
            $table->ipAddress('hs_dns2')->nullable();
            $table->string('hs_uamdomains')->nullable();
            #
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
        Schema::dropIfExists('pppoeconfigs');
    }
}
