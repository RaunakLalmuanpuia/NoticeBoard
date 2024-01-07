<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'thenzawlgolfresort@gmail.com',
            'password' => bcrypt('Thenzawlgolf!23'),
        ]);

        DB::table('users')->insert([
            'name' => 'MSeGS',
            'email' => 'admin@msegs.in',
            'password' => bcrypt('MSeGS!#22'),
        ]);
    }
}
