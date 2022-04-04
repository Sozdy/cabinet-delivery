<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionDeliveryTable extends Migration
{
    public function up()
    {
        Schema::create('action_delivery', function(Blueprint $table)
        {
            $table->id('id');
            $table->foreignId('delivery_id');
            $table->foreignId('action_id');
			
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('action_id')->references('id')->on('actions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('action_delivery');
    }
}
