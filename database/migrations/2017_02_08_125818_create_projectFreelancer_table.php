<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFreelancerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectFreelancer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('freelancer_id');
            $table->integer('status');
//            status=1 =>new
//            status=2 =>cancel
//            status=3 =>fullfil

//
//

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
        Schema::dropIfExists('projectFreelancer');
    }
}
