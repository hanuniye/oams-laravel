<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->string("image")->nullable();
            $table->integer("age");
            $table->integer("exprience");
            $table->integer("contact");
            $table->bigInteger("specialist_id")->unsigned();
            $table->foreign("specialist_id")->on("specializations")->references("id");
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->on("users")->references("id");
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
        Schema::dropIfExists('doctors');
    }
}
