<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class NoticeController extends Controller
{
  public function getNotice()
  {
    $documents = Document::get();
    return response()->json(['documents'=>$documents]);
  }

  public function customerNotice()
  {
    $documents = Document::paginate(10);
    return response()->json(['documents'=>$documents]);
  }

  public function addDocument(Request $request)
  {
    $document = new Document;
    $document->title = $request->title;
    $document->excerpt = $request->excerpt;
    if($request->document != 'null'){
      $fileName = \Str::random(30).time().'.'.$request->document->getClientOriginalExtension();
      $request->document->move(public_path('uploadedFiles'), $fileName);
      $document->file = '/uploadedFiles/'.$fileName;
    }
    $document->save();
    return response()->json(['success'=>'Document uploaded successfully']);
  }

  public function updateDocument(Request $request, $id)
  {
    $document = Document::findOrFail($id);
    $document->title = $request->title;
    $document->excerpt = $request->excerpt;
    if($request->document != 'null'){
      $fileName = \Str::random(30).time().'.'.$request->document->getClientOriginalExtension();
      $request->document->move(public_path('uploadedFiles'), $fileName);
      $document->file = '/uploadedFiles/'.$fileName;
    }
    $document->save();
    return response()->json(['success'=>'Document updated successfully']);
  }

  public function deleteDocument($id)
  {
    Document::findOrFail($id)->delete();
    return response()->json(['success'=>'Document deleted successfully']);
  }

}
