<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guide;
use App\Models\Category;

class GuideController extends Controller
{
  public function getGuideCategories()
    {
      $categories = Category::get();
      return response()->json(['categories'=>$categories], 200);
    }

    public function addGuide(Request $request)
    {
      $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('guideImages'), $imageName);
      $guide = new Guide;
      $guide->category_id = $request->category;
      $guide->image = 'guideImages/'.$imageName;
      $guide->title = $request->title;
      $guide->address = $request->address;
      $guide->contact = $request->contact;
      $guide->email = $request->email;
      $guide->save();
      return response()->json(['success'=>'Guide Added'], 200);
    }
    public function deleteGuide($id)
    {
      Guide::findOrFail($id)->delete();
      return response()->json(['success'=>'Guide Deleted']);
    }

    public function getGuideSingle($id)
    {
      $guide = Guide::findOrFail($id);
      return response()->json(['guide'=>$guide]);
    }

    public function updateGuide(Request $request, $id)
    {
      $guide = Guide::findOrFail($id);
      $guide->category_id = $request->category;
      if($request->image != 'null'){
        $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('guideImages'), $imageName);
        $guide->image = 'guideImages/'.$imageName;
      }
      $guide->title = $request->title;
      $guide->address = $request->address;
      $guide->contact = $request->contact;
      $guide->email = $request->email;
      $guide->save();
      return response()->json(['success'=>'Guide Updated'], 200);
    }
    public function getGuide()
    {
        $guides = Guide::with('category')->get();
        return response()->json(['guides'=>$guides], 200);
    }
}
