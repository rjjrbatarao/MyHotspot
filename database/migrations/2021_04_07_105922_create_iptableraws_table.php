<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIptablerawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iptableraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->string('process')->default('system');
            $table->string('chain')->nullable();
            $table->boolean('src_address_opt')->default(false);
            $table->string('src_address')->nullable();
            $table->boolean('dst_address_opt')->default(false);
            $table->string('dst_address')->nullable();
            $table->boolean('protocol_opt')->default(false);
            $table->string('protocol')->nullable();
            $table->boolean('src_port_opt')->default(false);
            $table->integer('src_port')->unsigned();
            $table->boolean('dst_port_opt')->default(false);
            $table->integer('dst_port')->unsigned();
            $table->integer('in_inteface_id')->unsigned();// all devices
            $table->boolean('in_inteface_opt')->default(false);
            $table->integer('out_inteface_id')->unsigned();// all devices
            $table->boolean('out_inteface_opt')->default(false);
            $table->string('action')->nullable();
            $table->string('jump_target')->nullable();     
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
        Schema::dropIfExists('iptableraws');
    }
}
