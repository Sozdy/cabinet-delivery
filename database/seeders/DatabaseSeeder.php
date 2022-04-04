<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
        $this->call(BrigadeTypesTableSeeder::class);
        $this->call(BrigadesTableSeeder::class);
        $this->call(DeliveryStatesTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(ActionDeliverySeeder::class);
    }
}
