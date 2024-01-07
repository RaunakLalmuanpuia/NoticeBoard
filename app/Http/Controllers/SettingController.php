<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
  public function getSettings()
  {
    $settings = Setting::get();
    return response()->json(['settings' => $settings]);
  }

  public function updateSetting(Request $request)
  {
    $setting = Setting::findOrFail($request->id);
    $setting->value = $request->value;
    $setting->notes = $request->notes;
    $setting->save();
    return response()->json(['success' => 'Setting Updated']);
  }

  public function getUserSettings()
  {
    $setting = Setting::where('key', 'Booking')->first();
    return response()->json(['setting' => $setting]);
  }
}
