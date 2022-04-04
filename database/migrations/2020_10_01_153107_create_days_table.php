<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id('id');
            $table->date('date')->unique();
            $table->integer('value')->nullable();
            $table->string('free_brigades')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('days');
    }
}
