<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
        [
            [
                'name'         => 'admin',
                'email'        => 'admin@admin.fr',
                'password'     => bcrypt('motdepasse')
            ],
            [
                'name'         => 'Thomas',
                'email'        => 'thomas@thomas.thomas',
                'password'     => bcrypt('motdepasse')
            ],
            [
                'name'         => 'Antoine',
                'email'        => 'antoine@antoine.antoine',
                'password'     => bcrypt('motdepasse')
            ],
            [
                'name'         => 'Manu',
                'email'        => 'manu@manu.manu',
                'password'     => bcrypt('motdepasse')
            ]
        ];


        User::insert($users);

    }
}
