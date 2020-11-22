<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorTable extends Migration
{
    public function up()
    {
        Schema::create('monitor', function (Blueprint $table) {

		$table->integer('id',11);
		$table->string('name',20);
		$table->text('URL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('monitor');
    }
}
