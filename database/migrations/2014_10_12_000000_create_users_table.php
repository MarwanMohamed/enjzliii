<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('mobile');
            $table->string('balance');
            $table->integer('mobile_country_id');
            $table->integer('country_id');
            $table->string('city');
            $table->dateTime('DOB');
            $table->integer('specialization_id');
            $table->boolean('emailConfirm');
            $table->boolean('mobileConfirm');
            $table->string('Brief',1000);
            $table->timestamp('lastLogin');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('type_id');
            $table->integer('status');
            //status=2 =>block
            $table->rememberToken();
            $table->integer('type');
//            type=1 =>projectOwner
//            type=2 =>freelancer
//            type=3 =>both
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
        Schema::dropIfExists('user');
    }
}
