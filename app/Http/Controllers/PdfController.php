<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use PDF;

class PdfController extends Controller
{
    public function generatePdf()
    {
      $detail = OrderDetail::where('order_id','1628924223')->first();
      $text = "$detail->name,";
      $text .= "$detail->order_id,";
      foreach($detail->orderedItem as $orderedItem){
        $text .= $orderedItem->item->name_of_item.",".$orderedItem->quantity;
      }
      
      $qr = \QrCode::size(500)->generate($text);
      $exploded = explode(PHP_EOL, $qr);
      $exploded = '/barcodes/DzmibaNw3kZgnnqPY7muJk9I27vdu820210813193158.svg';
      $svg = $qr;
      $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg).'" width="500" height="500" />'; 
      $data = ['qr'=>$html];
      view()->share('data',$data);
      $pdf = PDF::loadView('pdf.pdf_view', $data);

      // download PDF file with download method
      return $pdf->stream('pdf_file.pdf');
    }
}
