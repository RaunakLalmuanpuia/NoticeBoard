<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoticeBoard;
class NoticeBoardController extends Controller
{
  // For Customer Notice Homepage
    public function createNotice()
    {
      $noticeBoard = NoticeBoard::latest()->paginate(5);
      return response()->json(['noticeBoard' => $noticeBoard], 200);
    }
    // For Admin Notice Homepage
    public function adminNotice()
    {
      $noticeBoard = NoticeBoard::latest()->get();
      return response()->json(['noticeBoard' => $noticeBoard], 200);
    }
    // Create Notice
    public function addNotice(Request $request){
      $noticeBoard = new NoticeBoard;
      $noticeBoard->title = $request->title;
      $noticeBoard->content= $request->content;
      $noticeBoard->save();
      return response()->json(['success' => 'New Notice Added'], 200);
    }
    // For Homepage
    public function customerGetNotice()
    {
      $noticeBoard = NoticeBoard::latest()->take(2)->get();
      return response()->json(['noticeBoard' => $noticeBoard]);
    }
  //Delete Notice
    public function deleteNotice($id)
    {
      NoticeBoard::findOrFail($id)->delete();
      return response()->json(['success' => 'Notice deleted']);
    }
  
    public function updateNotice($id, Request $request)
    {
      $notice = NoticeBoard::findOrFail($id);
      $notice->title = $request->title;
      $notice->content = $request->content;
      $notice->created_at = now();
      $notice->save();
      return response()->json(['success' => 'Notice updated']);
    }
}
