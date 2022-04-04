<?php

namespace Database\Seeders;

use App\Models\BrigadeType;
use Illuminate\Database\Seeder;

class BrigadeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //BrigadeType::truncate();

        BrigadeType::create(['name'=> 'Мебель']);
        BrigadeType::create(['name'=> 'Перегородки']);
    }
}
