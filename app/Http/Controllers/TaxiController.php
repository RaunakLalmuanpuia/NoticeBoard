<?php

namespace App\Http\Controllers;

use App\Models\Taxi;
use Illuminate\Http\Request;

class TaxiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type') ?? 'taxi';
        return response()->json([
            'list' =>Taxi::query()
                ->where('auto',$type)
                ->paginate(15)
        ], 200);
    }
}
