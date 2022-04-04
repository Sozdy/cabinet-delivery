<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrigadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brigades', function (Blueprint $table)
        {
            $table->id('id');
            $table->string('phone');
            $table->string('contact_person');
            $table->string('car');
            $table->string('driver');
            $table->foreignId('brigade_type_id');
			
            $table->foreign('brigade_type_id')->references('id')->on('brigade_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brigades');
    }
}
