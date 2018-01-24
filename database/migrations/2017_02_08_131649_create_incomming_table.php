<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncommingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomming', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reciever_id');
            $table->integer('sender_id');
            $table->integer('type');
            //type =1 =>internal transaction
            //type =2 =>paypal transaction
            //type =3 =>visa transaction
            $table->text('transactionInfo');
            $table->integer('amount');
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
        Schema::dropIfExists('incomming');
    }
}
