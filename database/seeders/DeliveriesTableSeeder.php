<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DeliveriesTableSeeder extends Seeder
{
    public function run()
    {
        //Delivery::truncate();

        Delivery::create(
            [
                'date' => Carbon::parse('27-09-2020')->toDateString(),
                'previous_date' => null,
                'user_id' => 1,
                'brigade_id' => 1,
                'order' => null,
                'organization_name' => 'ООО Машиностроение',
                'organization_address' => 'ул.Вторая, д.4',
                'is_region' => false,
                'contact_person' => 'Иванов Иван Иванович',
                'phone' => '8-999-999-99-99',
                'comment' => 'Позвонить за 20 минут',
                'is_paid' => true,
                'is_available' => true,
                'account' => 'M0000000045',
                'selling' => '308 от 03.09',
                'value' => 100,
                'delivery_state_id' => 1
            ]);

        Delivery::create(
            [
                'date' => Carbon::parse('27-09-2020')->toDateString(),
                'previous_date' => Carbon::parse('20-09-2020')->toDateString(),
                'user_id' => 3,
                'brigade_id' => 1,
                'order' => null,
                'organization_name' => 'ООО Машиностроение',
                'organization_address' => 'ул.Вторая, д.5',
                'is_region' => true,
                'contact_person' => 'Иванов Иван Иванович',
                'phone' => '8-999-999-99-99',
                'comment' => 'Позвонить за 20 минут',
                'is_paid' => false,
                'is_available' => false,
                'account' => 'M0000000046',
                'selling' => '3012 от 03.09',
                'value' => 200,
                'delivery_state_id' => 3
            ]);

        Delivery::create(
            [
                'date' => Carbon::parse('27-09-2020')->toDateString(),
                'previous_date' => Carbon::parse('20-09-2020')->toDateString(),
                'user_id' => 3,
                'brigade_id' => 1,
                'order' => null,
                'organization_name' => 'ООО Машиностроение',
                'organization_address' => 'ул.Вторая, д.5',
                'is_region' => true,
                'contact_person' => 'Иванов Иван Иванович',
                'phone' => '8-999-999-99-99',
                'comment' => 'Позвонить за 20 минут',
                'is_paid' => false,
                'is_available' => false,
                'account' => 'M0000000046',
                'selling' => '3012 от 03.09',
                'value' => 200,
                'delivery_state_id' => 4
            ]);
    }
}
