<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{
  public function addFacility(Request $request)
  {
    $facility = new Facility;
    $facility->title = $request->title;
    if($request->image != "null"){
      $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('facilityImages'), $imageName);
      $facility->image = 'facilityImages/'.$imageName;
    }
    $facility->description = $request->description;
    $facility->save();
    return response()->json(['success'=>'Facility Added']);
  }

  public function getFacilities()
  {
    $facilities = Facility::get();
    return response()->json(['facilities'=>$facilities], 200);
  }

  public function getFacilitySingle($id)
  {
    $facility = Facility::findOrFail($id);
    return response()->json(['facility'=>$facility],200);
  }

  public function deleteFacility($id)
  {
    Facility::findOrFail($id)->delete();
    return response()->json(['success'=>'Facility Deleted']);
  }

  public function updateFacility($id, Request $request)
  {
    $facility = Facility::findOrFail($id);
    $facility->title = $request->title;
    if($request->image != "null"){
      $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('facilityImages'), $imageName);
      $facility->image = 'facilityImages/'.$imageName;
    }
    $facility->description = $request->description;
    $facility->save();
    return response()->json(['success'=>'Facility Updated']);
  }
}
