<?php

namespace Database\Seeders;

use App\Models\TourGuide;
use Illuminate\Database\Seeder;

class TourGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TourGuide::query()->upsert([
            ['id'=>1,'name'=>'PC Lalmuansanga','contact'=>'8416076216'],
            ['id'=>2,'name'=>'R.Lalremliana','contact'=>'8837467692'],
            ['id'=>3,'name'=>'Lalpekhlua','contact'=>'6009039339'],
            ['id'=>4,'name'=>'Ramsangzuala','contact'=>'9366477142'],
            ['id'=>5,'name'=>'Lallianpuia','contact'=>'9370450895'],
            ['id'=>6,'name'=>'Lalhmangaihzuali','contact'=>'9863060624'],
            ['id'=>7,'name'=>'Joseph Lalhriatdika','contact'=>'8794799789'],
        ], ['id']);
    }
}
