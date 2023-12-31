<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('users')->insert(
            [
                'username' => 'yanti',
                'password' => Hash::make('yanti123'),
                'email' => 'yanti14@gmail.com',


            ],
        
         );
    }
}
