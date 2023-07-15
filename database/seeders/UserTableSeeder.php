<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'      => 'Yusman Yulianto',
                'email'     => 'admin@gmail.com',
                'password'  => bcrypt('password'),

            ],
            [
                'name'      => 'Kholes A',
                'email'     => 'kholes@gmail.com',
                'password'  => bcrypt('123456'),

            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
