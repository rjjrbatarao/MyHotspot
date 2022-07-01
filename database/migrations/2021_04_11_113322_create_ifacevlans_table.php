<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfacevlansTable extends Migration
{
    /**
     * Run the migrations. creatable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifacevlans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment',255)->nullable();
            $table->string('iftype')->default('vlan');
            $table->string('ifname')->unique();
            $table->string('status')->default('unassigned');
            $table->string('status_main')->default('down');
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
        Schema::dropIfExists('ifacevlans');
    }
}
