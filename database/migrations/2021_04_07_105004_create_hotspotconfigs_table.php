<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotspotconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotspotconfigs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('status')->nullable()->default('disabled');
            $table->boolean('type')->default(true);
            $table->string('comment',255)->nullable();
            $table->boolean('enable_radius')->default(true);
            $table->boolean('shared_user')->default(false);
            $table->integer('na_id')->unsigned();// nas           
            $table->boolean('enable_ttl_1')->default(false);// toggle type
            $table->integer('ttl_value')->unsigned();
            $table->integer('adapter_id')->unsigned();/// filter if lan lanif
            $table->integer('clientportal_id')->unsigned();
            $table->integer('max_host')->nullable(); //compute this using subnet mask
            $table->boolean('custom_portal')->default(false);// toggle
            $table->string('html_directory')->default('/hotspot');// directory
            $table->boolean('autodelete_expired')->default(true);//toggle delete client record when expired
            $table->integer('autodelete_delay')->unsigned();
            #poc
            $table->boolean('enable_mikrotik')->default(false);// mikrotik cluster proof of concept
            #chilli settings
            $table->string('hs_lanif')->default('eth0');
            $table->integer('hs_uamport')->unsigned();
            $table->integer('hs_uamuiport')->unsigned();
            $table->ipAddress('hs_network')->nullable();
            $table->ipAddress('hs_netmask')->nullable();
            $table->ipAddress('hs_uamlisten')->nullable();
            $table->ipAddress('hs_dns1')->nullable();
            $table->ipAddress('hs_dns2')->nullable();
            $table->json('hs_uamallow')->nullable();
            $table->json('hs_uamdomains')->nullable();
            $table->integer('hs_coaport')->default(3799);
            $table->string('hs_coanoipcheck')->default('on');
            
             # radius
            $table->boolean('enable_external_radius')->default(false);
            $table->string('hs_nasid')->default('nas01');
            $table->string('hs_radius')->default('localhost');
            $table->string('hs_radius2')->default('localhost');
            $table->string('hs_radsecret')->default('testing123');
            $table->string('hs_uamsecret')->default('@secret!23');
            $table->string('hs_uamaliasname')->default('mywifi');

            $table->string('hs_uamformat')->default('http://$HS_UAMLISTEN/session');
            $table->string('hs_uamhomepage')->default('http://$HS_UAMLISTEN/check');
            
            # squid
            $table->boolean('enable_squid')->default(false);
            $table->string('hs_postauth_proxy')->nullable();
            $table->integer('hs_postauth_proxyport')->unsigned()->nullable();

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
        Schema::dropIfExists('hotspotconfigs');
    }
}
