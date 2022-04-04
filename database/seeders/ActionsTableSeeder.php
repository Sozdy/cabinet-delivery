<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Action::truncate();

        Action::create(['name'=> 'Доставка']);
        Action::create(['name'=> 'Сборка']);
        Action::create(['name'=> 'Замена брака']);
        Action::create(['name'=> 'Ремонт']);
        Action::create(['name'=> 'Вывоз мусора']);
        Action::create(['name'=> 'Перегруз']);
        Action::create(['name'=> 'Другое']);
        Action::create(['name'=> 'Получение груза']);
        Action::create(['name'=> 'Замена масла']);
    }
}
