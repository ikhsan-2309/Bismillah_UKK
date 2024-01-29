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
        $users = array(
            [
                'name' => 'Kasir 1',
                'email' => 'kasir1@gmail.com',
                'password' => bcrypt('123'),
                'gambar' => '/img/user.jpg',
                'level' => 0
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}
