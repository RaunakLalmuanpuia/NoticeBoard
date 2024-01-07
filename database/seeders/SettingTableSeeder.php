<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $setting = [
      'key' => 'booking',
      'value' => 'off',
    ];
    Setting::create($setting);
  }
}
