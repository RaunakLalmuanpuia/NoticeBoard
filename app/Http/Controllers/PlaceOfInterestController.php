<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlaceOfInterest;

class PlaceOfInterestController extends Controller
{
  public function addPlaceOfInterest(Request $request)
  {
    $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
    $request->image->move(public_path('interestImages'), $imageName);
    $placeOfInterest = new PlaceOfInterest;
    $placeOfInterest->image = 'interestImages/'.$imageName;
    $placeOfInterest->title = $request->title;
    $placeOfInterest->address = $request->address;
    $placeOfInterest->contact = $request->contact;
    $placeOfInterest->email = $request->email;
    $placeOfInterest->save();
    return response()->json(['success'=>'Place of Interest Added'], 200);
  }

  public function getPlaceOfInterest()
  {
    $placeOfInterest = PlaceOfInterest::get();
    return response()->json(['placeOfInterests'=>$placeOfInterest], 200);
  }

  public function deletePlaceOfInterest($id)
  {
    PlaceOfInterest::findOrFail($id)->delete();
    return response()->json(['success'=>'Place of Interest Deleted']);
  }
  public function getPlaceOfInterestSingle($id)
  {
    $interest = PlaceOfInterest::findOrFail($id);
    return response()->json(['interest'=>$interest],200);
  }

  public function updatePlaceOfInterest(Request $request, $id)
  {
    $placeOfInterest = PlaceOfInterest::findOrFail($id);
    if($request->image != 'null'){
      $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('interestImages'), $imageName);
      $placeOfInterest->image = 'interestImages/'.$imageName;
    }
    $placeOfInterest->title = $request->title;
    $placeOfInterest->address = $request->address;
    $placeOfInterest->contact = $request->contact;
    $placeOfInterest->email = $request->email;
    $placeOfInterest->save();
    return response()->json(['success'=>'Place of Interest Updated']);
  }
}
