<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIptablenatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iptablenats', function (Blueprint $table) {
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
            $table->boolean('in_inteface_opt')->default(false);
            $table->integer('in_inteface_id')->unsigned();// all devices
            $table->boolean('out_inteface_opt')->default(false);
            $table->integer('out_inteface_id')->unsigned();// all devices
            $table->boolean('packet_mark_opt')->default(false);
            $table->integer('packet_mark')->unsigned();
            $table->boolean('con_mark_opt')->default(false);
            $table->integer('con_mark')->unsigned();
            $table->boolean('con_type_opt')->default(false);
            $table->string('con_type')->nullable();
            $table->string('action')->nullable();
            $table->string('jump_target')->nullable();
            $table->integer('to_ports')->unsigned();         
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
        Schema::dropIfExists('iptablenats');
    }
}
