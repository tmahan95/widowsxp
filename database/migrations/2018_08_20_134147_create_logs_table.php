<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
		$table->increments('id');
		$table->string('date');
		$table->string('uname');
		$table->string('compname');
		$table->string('ipaddress');
		$table->string('os_version');
		$table->string('os_build');
		$table->string('bios_version');
		$table->string('bios_date');
		$table->string('model');
		$table->string('serial');
            	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
