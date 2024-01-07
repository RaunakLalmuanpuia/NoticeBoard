<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsEvent;

class NewsController extends Controller
{

  public function customerGetNews()
  {
    $news = NewsEvent::paginate(10);
    return response()->json(['news' => $news]);
  }
  public function addNewsEvent(Request $request)
  {
    $newsEvent = new NewsEvent;
    $newsEvent->date_of_event = $request->date;
    $newsEvent->title = $request->title;
    $newsEvent->content = $request->content;
    if ($request->file != 'null') {
      $fileName = \Str::random(30) . time() . '.' . $request->file->getClientOriginalExtension();
      $request->file->move(public_path('uploadedFiles'), $fileName);
      $newsEvent->file = '/uploadedFiles/' . $fileName;
    }
    $newsEvent->save();
    return response()->json(['success' => 'News and Event added'], 200);
  }

  public function getNews()
  {
    $news = NewsEvent::all();
    return response()->json(['news' => $news], 200);
  }

  public function getNewsSingle($id)
  {
    $news = NewsEvent::findOrFail($id);
    return response()->json(['news' => $news]);
  }

  public function deleteNews($id)
  {
    NewsEvent::findOrFail($id)->delete();
    return response()->json(['success' => 'News and Event deleted']);
  }

  public function updateNews($id, Request $request)
  {
    $newsEvent = NewsEvent::findOrFail($id);
    $newsEvent->date_of_event = $request->date;
    $newsEvent->title = $request->title;
    $newsEvent->content = $request->content;
    if ($request->file != 'null') {
      $fileName = \Str::random(30) . time() . '.' . $request->file->getClientOriginalExtension();
      $request->file->move(public_path('uploadedFiles'), $fileName);
      $newsEvent->file = '/uploadedFiles/' . $fileName;
    }
    $newsEvent->save();
    return response()->json(['success' => 'News and Event updated']);
  }

  public function getNotificationsCount()
  {
    $from = substr(now(), 0, 10);
    $to = substr(now()->addDays(7), 0, 10);
    $newsEvent = NewsEvent::whereBetween('date_of_event', [$from, $to])->count();
    return response()->json(['notifications' => $newsEvent]);
  }
}
