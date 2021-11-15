<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmsTable extends Migration
{
    public function up()
    {
        Schema::create('vms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->unsignedBigInteger('src_vcenter_id');
            $table->unsignedBigInteger('dst_vcenter_id');
            $table->string('task_id')
                ->nullable();
            $table->string('status')
                ->default('idle');
            $table->unsignedBigInteger('percentage')
                ->default(0);

            $table->timestamps();

            $table->foreign('src_vcenter_id')
                ->references('id')
                ->on('vcenters');

            $table->foreign('dst_vcenter_id')
                ->references('id')
                ->on('vcenters');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vms');
    }
}
