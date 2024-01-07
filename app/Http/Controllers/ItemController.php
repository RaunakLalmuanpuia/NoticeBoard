<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Rate;

class ItemController extends Controller
{
  public function getSingleItem($id)
  {
    $item = Item::findOrFail($id);
    return response()->json(['item'=>$item]);
  }

  public function updateItem(Request $request, $id)
    {
      $item = Item::findOrFail($id);
      $item->name_of_item = $request->name;
      if($request->picture != 'null'){
        $imageName = \Str::random(30).time().'.'.$request->picture->getClientOriginalExtension();
        $request->picture->move(public_path('itemImages'), $imageName);
        $item->picture = "itemImages/".$imageName;
      }
      $item->remark = $request->instruction;
      $item->type = $request->type;
      $item->save();
        
      foreach($request->rates as $rates){
        $rate_decoded = json_decode($rates);
        if($rate_decoded->id == 0){
          $rat = new Rate;
          $rat->item_id = $item->id;
          $rat->rate = $rate_decoded->rate;
          $rat->type = $rate_decoded->type;
          $rat->save();
        }else{
          $rat = Rate::where('id',$rate_decoded->id)->first();
          $rat->item_id = $item->id;
          $rat->rate = $rate_decoded->rate;
          $rat->type = $rate_decoded->type;
          $rat->save();
        }
      }
      return response()->json(['success'=>'Item added successfully'], 200);
    }
}
