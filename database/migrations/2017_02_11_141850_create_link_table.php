<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',250);
            $table->string('email');
            $table->string('token')->index();
            $table->integer('type');

            //status=1 => confirm Email
            //status=2 => confirm mobile
            //status=3 => forget password
            $table->boolean('status');
//            status=1 =>new
//            status=2 =>finish
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
        Schema::dropIfExists('link');
    }
}
