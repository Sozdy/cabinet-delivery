<?php

namespace Database\Seeders;

use App\Models\ActionDelivery;
use Illuminate\Database\Seeder;

class ActionDeliverySeeder extends Seeder
{
    public function run()
    {
        //ActionDelivery::truncate();

        ActionDelivery::create(['delivery_id' => 1, 'action_id' => 1]);
        ActionDelivery::create(['delivery_id' => 1, 'action_id' => 3]);
        ActionDelivery::create(['delivery_id' => 1, 'action_id' => 5]);

        ActionDelivery::create(['delivery_id' => 2, 'action_id' => 2]);
        ActionDelivery::create(['delivery_id' => 2, 'action_id' => 3]);
        ActionDelivery::create(['delivery_id' => 2, 'action_id' => 4]);
    }
}
