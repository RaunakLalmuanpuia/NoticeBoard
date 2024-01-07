<?php

namespace App\Http\Controllers;

use App\Models\TourGuide;
use Illuminate\Http\Request;

class TourGuideController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'list' =>TourGuide::query()
                ->paginate(15)
        ], 200);
    }
}
