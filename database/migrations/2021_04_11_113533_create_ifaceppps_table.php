<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfacepppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifaceppps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iftype')->default('ppp');
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
        Schema::dropIfExists('ifaceppps');
    }
}
