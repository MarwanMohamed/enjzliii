<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('ProfessionalAtWork');
            $table->integer('CommunicationAndMonitoring');
            $table->integer('quality');
            $table->integer('experience');
            $table->integer('workAgain');
            $table->integer('projectOwner_id');
            $table->boolean('toFreelancer');
//            toFreelancer=1=>evaluate for freelancer
//            toFreelancer=2=>evaluate for projectOwner
            $table->integer('freelancer_id');
            $table->integer('evaluating_owner');
//            "الشخص الذي تم تقيمه"
            $table->integer('evaluated_id');
//            "الشخص الذي قيم"
            $table->text('note');
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
        Schema::dropIfExists('evaluate');
    }
}
