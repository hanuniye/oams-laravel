<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePateintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pateints', function (Blueprint $table) {
            $table->id();
            $table->String("fullname");
            $table->String("name");
            $table->String("gender");
            $table->date("birth_date");
            $table->integer("contact");
            $table->integer("age");
            $table->bigInteger("doctor_id")->unsigned()->nullable();
            $table->foreign("doctor_id")->on("doctors")->references("id");
            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->on("users")->references("id");
            $table->string("status")->default("booked");
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
        Schema::dropIfExists('pateints');
    }
}
