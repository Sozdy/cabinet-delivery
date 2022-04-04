<?php

namespace Database\Seeders;

use App\Models\Brigade;
use Illuminate\Database\Seeder;

class BrigadesTableSeeder extends Seeder
{
    public function run()
    {
        Brigade::create(
            [
                'phone' => '8-999-999-99-97',
                'contact_person' => 'Сидоров Сидор Сидорович',
                'car' => 'ГАЗель NEXT А578АК 125rus',
                'driver' => 'Паровозик',
                'brigade_type_id' => 1
            ]
        );
    }
}
