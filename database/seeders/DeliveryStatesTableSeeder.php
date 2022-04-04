<?php

namespace Database\Seeders;

use App\Models\DeliveryState;
use Illuminate\Database\Seeder;

class DeliveryStatesTableSeeder extends Seeder
{
    public function run()
    {
        //DeliveryState::truncate();

        DeliveryState::create(['name' => 'В обработке']);
        DeliveryState::create(['name' => 'В процессе доставки']);
        DeliveryState::create(['name' => 'Проблемы с доставкой']);
        DeliveryState::create(['name' => 'Доставлено']);
    }
}
