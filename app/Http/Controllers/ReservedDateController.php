<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ReservedDate;
use Illuminate\Http\Request;

class ReservedDateController extends Controller
{
    public function getDates()
    {
        return ReservedDate::with('item:id,name_of_item')->orderBy('created_at', 'DESC')->get();
    }

    public function addDate(Request $request)
    {
        $request->validate([
            'items' => 'required',
            'dates' => 'required',
        ]);


        foreach ($request->items as $item) {
            $dt = new ReservedDate;
            $dt->item_id = $item;
            $dt->date = today();
            $dt->dates = $request->dates;
            $dt->save();
        }


        return back();
    }

    public function updateDate($id, Request $request)
    {
        $request->validate([
            'item' => 'required',
            'dates' => 'required',
        ]);

        $dt = ReservedDate::findOrFail($id);
        $dt->item_id = $request->item;
        $dt->dates = $request->dates;
        $dt->save();

        return back();
    }

    public function deleteDate($id)
    {
        return ReservedDate::findOrFail($id)->delete();
    }

    public function getDateById($id)
    {
        return ReservedDate::where('item_id', $id)->get();
    }

    public function getAllItems()
    {
        return Item::orderBy('name_of_item', 'ASC')->select('id', 'name_of_item')->get();
    }
}
