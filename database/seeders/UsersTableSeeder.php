<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::truncate();

        User::create($this->getUserArray('Test Admin', 'test', Hash::make('test'), 1));
        User::create($this->getUserArray('Test Admin', 'admin', Hash::make('admin'), true));
        User::create($this->getUserArray('Test User', 'user', Hash::make('user'), false));

        foreach (User::factory()->count(25)->make() as $user)
        {
            User::create($this->getUserArray($user->name, $user->login, $user->password, $user->is_admin));
        }
    }

    private function getUserArray($name, $login, $password, $is_admin)
    {
        return
        [
            'name' => $name,
            'login' => $login,
            'password' => $password,
            'is_admin' => $is_admin
        ];
    }
}
