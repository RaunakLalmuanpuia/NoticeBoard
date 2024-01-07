<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Rent A Car'],
            ['id' => 2, 'name' => 'Where To Stay'],
            ['id' => 3, 'name' => 'Find Me Food'],
        ];
        \DB::table('categories')->insert($categories);
    }
}
