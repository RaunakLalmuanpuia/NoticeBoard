<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OrderDetail;
use App\Models\OrderedItem;
use App\Models\Payment;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
  public function payment(Request $request)
  {
    $order_detail = new OrderDetail;
    $order_detail->order_id = \Carbon\Carbon::now()->timestamp;
    $order_detail->barcode = 'null';
    $order_detail->name = $request->name;
    $order_detail->email = $request->email;
    $order_detail->contact = $request->contact;
    $order_detail->save();

    $ordered_item = new OrderedItem;
    $ordered_item->order_details_id = $order_detail->id;
    $ordered_item->item_id = $request->item_id;
    $ordered_item->quantity = $request->quantity;
    $ordered_item->date_from = $request->date_from;
    $ordered_item->date_to = $request->date_to;
    $ordered_item->save();

    $rate = Rate::where('item_id', $request->item_id)->where('type', 'Amount')->first();
    $item = Item::find($request->item_id);

    $discount = 0;
    if ($item->name_of_item == 'Day Pass') {
      if ($request->quantity >= 21) {
        $discount = ($rate->rate * $request->quantity) * 0.6;
      } else if ($request->quantity >= 11) {
        $discount = ($rate->rate * $request->quantity) * 0.4;
      } else if ($request->quantity >= 5) {
        $discount = ($rate->rate * $request->quantity) * 0.3;
      }
      $total = ($rate->rate * $request->quantity) - $discount;
    } elseif ($item->name_of_item == 'Videography' || $item->name_of_item == 'Photography' || $item->name_of_item == 'Camera' || $item->name_of_item == 'Video Camera') {
      if ($request->quantity >= 21) {
        $discount = (200 * $request->quantity) * 0.6;
      } else if ($request->quantity >= 11) {
        $discount = (200 * $request->quantity) * 0.4;
      } else if ($request->quantity >= 5) {
        $discount = (200 * $request->quantity) * 0.3;
      }
      $total = ((200 * $request->quantity) - $discount) + $rate->rate;
    } else {
      $total = ($rate->rate * $request->quantity * $request->no_of_days);
    }

    if ($total != $request->amount) {
      return response()->json(['error' => 'Amount and quantity mismatch']);
    }

    return response()->json([
      'ss' => $order_detail->id,
    ], 201);
  }

  public function responseHandler(Request $request)
  {
    $api = new Api("rzp_test_17L4YGExv28au1", "EN4YOs8FaUKrMi9i2Ep2g9lW");
    $payment = $api->payment->fetch($request->payment_id);
    $captured = $payment->capture(array('amount' => $request->amount));
    if ($captured->captured == "true") {
      $payment = new Payment;
      $payment->order_id = $request->order_id;
      $payment->payment_id = $request->payment_id;
      $payment->amount = $request->amount / 100;
      $payment->save();

      $details = OrderDetail::where('order_id', $request->order_id)->first();
      $details->payment_status = 'Success';
      $path = $this->generateBarcode($request->order_id);
      $details->barcode = $path;
      $details->save();
      $encrypted = Crypt::encryptString($details->id);
      $redirectURL = '/order-complete/' . $encrypted;
    } else {
      $encrypted = Crypt::encryptString('error');
      $details = OrderDetail::where('order_id', $request->order_id)->first();
      $details->payment_status = 'Cancelled';
      $details->save();
      $redirectURL = '/order-complete/' . $encrypted;
    }
    $encrypted = Crypt::encryptString($details->id);

    $redirectURL = '/order-complete/' . $encrypted;

    return response()->json(['url' => $redirectURL]);
  }
  public function generateBarcode($orderId)
  {
    $imageName = \Str::random(30) . date('YmdHis') . '.svg';
    $path = public_path() . '/barcodes/' . $imageName;
    \QrCode::generate($orderId, $path);
    return '/barcodes/' . $imageName;
  }
}
