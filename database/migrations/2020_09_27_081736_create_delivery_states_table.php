<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryStatesTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_states', function(Blueprint $table)
        {
            $table->id('id');
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_states');
    }
}
