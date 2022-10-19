<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->time("time");
            $table->string("reason");
            $table->string("status")->default("booked");
            $table->string("type")->default("no");
            $table->bigInteger("doctor_id")->unsigned();
            $table->foreign("doctor_id")->on("doctors")->references("id");
            $table->bigInteger("pateint_id")->unsigned();
            $table->foreign("pateint_id")->on("pateints")->references("id");
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
        Schema::dropIfExists('appointments');
    }
}
