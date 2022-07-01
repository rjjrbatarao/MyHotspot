<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfaceethernetsTable extends Migration
{
    /**
     * Run the migrations. view only
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifaceethernets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iftype')->default('ethernet');
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
        Schema::dropIfExists('ifaceethernets');
    }
}
