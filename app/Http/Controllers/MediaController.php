<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Gallery;

class MediaController extends Controller
{
    public function getGallery()
    {
      $galleries = Gallery::get();
      return response()->json(['galleries'=>$galleries], 200);
    }

    public function addGallery(Request $request)
    {
      $imageName = \Str::random(30).time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('guideImages'), $imageName);
      $gallery = new Gallery;
      $gallery->title = $request->title;
      $gallery->image = '/guideImages/'.$imageName;
      $gallery->save();
      return response()->json(['success'=>'Gallery Image Added Successfullt'], 200);
    }

    public function deleteImage($id)
    {
      Gallery::findOrFail($id)->delete();
      return response()->json(['success'=>'Image deleted']);
    }

    public function getVideo()
    {
      $videos = Video::get();
      return response()->json(['videos' => $videos], 200);
    }

    public function addVideo(Request $request)
    {
      $video = new Video;
      $video->title = $request->title;
      $video->video_id = $request->videoId;
      $video->save();
      return response()->json(['success'=>'Video Added Successfullt'], 200);
    }

    public function deleteVideo($id)
    {
      Video::findOrFail($id)->delete();
      return response()->json(['success'=>'Video deleted']);
    }
}
