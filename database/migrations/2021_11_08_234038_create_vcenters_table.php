<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVcentersTable extends Migration
{
    public function up()
    {
        Schema::create('vcenters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('host');
            $table->string('esxi');
            $table->string('user');
            $table->string('password');
            $table->string('datastore');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vcenters');
    }
}
