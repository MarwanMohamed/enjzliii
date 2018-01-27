<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('reciever_id');
            $table->integer('project_id');
            $table->integer('show')->default(1);
            $table->integer('updated')->default(0);
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
        Schema::dropIfExists('edit_prices');
    }
}
