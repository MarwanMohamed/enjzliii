<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privateProject', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->text('description');
            $table->integer('budget_id');
            $table->integer('deliveryDuration');
            $table->text('files');
            $table->text('attachment');
            $table->boolean('status');
            $table->integer('projectOwner_id');
            $table->integer('freelancer_id');
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
        Schema::dropIfExists('privateProject');
    }
}
