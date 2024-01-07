<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Rating;
use App\Models\Visitor;

class RatingController extends Controller
{
  public function giveRating(Request $request)
  {
    $rating = new Rating;
    $rating->name = $request->name;
    $rating->comment = $request->comment;
    $rating->rate = $request->rate;
    $rating->save();
    return response()->json(['success' => 'Rating Saved']);
  }

  public function averageRating()
  {
    $siteVisitors = Visitor::where('date', today())->count();
    $siteVisitorsAll = Visitor::count();
    $rating = Rating::sum('rate');
    $totalRating = Rating::count();
    if ($totalRating != 0) {
      $average = $rating / $totalRating;
    } else {
      $average = $rating;
    }
    $average = number_format($average, 1, '.', '');
    $visitors = OrderDetail::where('status', 'Visited')->count();
    return response()->json(['averageRating' => $average, 'visitors' => $visitors, 'siteVisitors' => $siteVisitors, 'siteVisitorsAll' => $siteVisitorsAll]);
  }
}
