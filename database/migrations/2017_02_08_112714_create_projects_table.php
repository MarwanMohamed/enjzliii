<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->text('description');
            $table->integer('budget_id');
            $table->integer('deliveryDuration');
            $table->text('files');
            $table->text('attachment');
            $table->boolean('status');
//            status = 1 new Project
//            status = 2 open project
//            status = 3 in progress
//            status = 4  cancel
//            status = 5  close
//            status = 6  fullfil
//
            $table->integer('projectOwner_id');
            $table->tinyInteger('isView')->defualt(0);
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
        Schema::dropIfExists('projects');
    }
}
