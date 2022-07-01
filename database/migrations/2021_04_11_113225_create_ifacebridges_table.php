<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfacebridgesTable extends Migration
{
    /**
     * Run the migrations. creatable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifacebridges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment',255)->nullable();
            $table->string('iftype')->default('bridge');
            $table->string('ifname')->unique();
            $table->boolean('stp')->nullable(); // stp on off
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
        Schema::dropIfExists('ifacebridges');
    }
}
