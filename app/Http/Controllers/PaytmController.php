<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Paytm\PaytmChecksum;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderedItem;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaytmController extends Controller
{
  private $mid = "Thenza66312387975501";
  private $merchantKey = "x0JUHzZhznGtNzOu";
  private $websiteName = "DEFAULT";
  private $channel = "WEB";

  public function payment(Request $request)
  {
    $order_detail = new OrderDetail;
    $order_detail->order_id = now()->timestamp;
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
    $ordered_item->expected_arrival = $request->expected_arrival;
    $ordered_item->no_of_children = $request->no_of_children;
    $ordered_item->no_of_adult = $request->no_of_adult;
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
      'sss' => $order_detail->order_id,
      'amount' => $total,
      'no_of_days' => $request->no_of_days,
    ], 201);
  }

  public function initiateTransaction(Request $request)
  {
    $orderId = $request->order_id;
    $order_detail = OrderDetail::where('order_id', $orderId)->first();

    $callbackUrl = 'https://thenzawlgolfresort.com/api/response-handler';
    $stagingCallback = 'http://localhost:8000/api/response-handler';

    $paytmParams = array();

    $paytmParams["body"] = array(
      "requestType" => "Payment",
      "mid" => $this->mid,
      "websiteName" => $this->websiteName,
      "orderId" => $orderId,
      "callbackUrl" => env('APP_DEBUG')?$stagingCallback:$callbackUrl,
      "txnAmount" => array(
        "value" => $request->amount,
        "currency" => "INR",
      ),
      "userInfo" => array(
        "custId" => $order_detail->id,
        "mobile" => $order_detail->contact,
        "email" => $order_detail->email,
        "firstName" => $order_detail->name,
      ),
    );

    /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
    */

      $mid = env('MID', 'Thenza66312387975501');
      $mkey = env('MKEY', 'x0JUHzZhznGtNzOu');
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $mkey);
    // $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$this->mid&orderId=$orderId";

    /* for Production */
    $stagingUrl = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$mid&orderId=$orderId";
    $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=$mid&orderId=$orderId";

    $paytmParams["head"] = array(
      "signature" => $checksum,
      "requestTimestamp" => now()->timestamp,
      "channelId" => $this->channel,
    );

    $response = Http::withHeaders([
      "accept" => "application/json",
      "content-type" => "application/json"
    ])->post(env('APP_DEBUG')?$stagingUrl:$url, $paytmParams);

    if ($response->status() == 200) {
      $result = json_decode($response->body(), true);
      $head = $result['head'];
      $body = $result['body'];
      $resultInfo = $body['resultInfo'];

      if ($resultInfo['resultStatus'] === 'S') {
        return response()->json([
          'token' => $body['txnToken'],
          'orderId' => $orderId,
          'amount' => $request->amount,
          "checksum" => $checksum
        ], 200);
      };
      return $resultInfo['resultMsg'];
    } else {
      throw new \Exception("Something went wrong");
    }

    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    $res = json_decode($response);
    return $res;
  }


  public function responseHandler(Request $request)
  {
    $paytmParams = array();
    $paytmChecksum = '';
    foreach ($request->all() as $key => $value) {
      if ($key == "CHECKSUMHASH") {
        $paytmChecksum = $value;
      } else {
        $paytmParams[$key] = $value;
      }
    }
    $orderId = $paytmParams['ORDERID'];

    if ($paytmParams['STATUS'] == 'TXN_SUCCESS') {
      $isValidChecksum = PaytmChecksum::verifySignature($paytmParams, $this->merchantKey, $paytmChecksum);
      if (!$isValidChecksum == "TRUE") {
        throw new \Exception('Unauthorized payment');
      }
      $path = $this->generateBarcode($orderId);
      $orderDetail = OrderDetail::where('order_id', $orderId)->first();
      $orderDetail->barcode = $path;
      $orderDetail->payment_status = 'Success';
      $orderDetail->save();

      $order = new Order;
      $order->order_id = $orderId;
      $order->tracking_id = $paytmParams['TXNID'];
      $order->bank_ref_no = '';
      $order->order_status = 'Success';
      $order->payment_mode = $paytmParams['PAYMENTMODE'];
      $order->card_name = '';
      $order->currency = $paytmParams['CURRENCY'];
      $order->amount = $paytmParams['TXNAMOUNT'];;
      $order->billing_name = '';
      $order->discount_value = '';
      $order->mer_amount = $paytmParams['TXNAMOUNT'];
      $order->billing_notes = '';
      $order->trans_date = $paytmParams['TXNDATE'];
      $order->save();

      $encrypted = Crypt::encryptString($orderDetail->id);
      $redirectURL = '/order-complete/' . $encrypted;
      return redirect($redirectURL);
    } else {
      $order = new Order;
      $order->order_id = $orderId;
      if (array_key_exists('TXNID', $paytmParams)) {
        $order->tracking_id = $paytmParams['TXNID'];
      }
      $order->bank_ref_no = $paytmParams['BANKTXNID'];
      $order->order_status = 'Failure';
      $order->payment_mode = $paytmParams['PAYMENTMODE'];
      $order->card_name = '';
      $order->currency = $paytmParams['CURRENCY'];
      $order->amount = $paytmParams['TXNAMOUNT'];;
      $order->billing_name = '';
      $order->discount_value = '';
      $order->mer_amount = $paytmParams['TXNAMOUNT'];
      $order->billing_notes = '';
      $order->trans_date = $paytmParams['TXNDATE'];
      $order->save();

      $orderDetail = OrderDetail::where('order_id', $orderId)->first();
      $orderDetail->payment_status = 'Failure';
      $orderDetail->save();

      $encrypted = Crypt::encryptString('error');
      $redirectURL = '/order-complete/' . $encrypted;
      return redirect($redirectURL);
    }
  }

  public function generateBarcode($orderId)
  {
    $imageName = Str::random(30) . date('YmdHis') . '.svg';
    $path = public_path() . '/barcodes/' . $imageName;
    \QrCode::generate($orderId, $path);
    return '/barcodes/' . $imageName;
  }

  public function statusApi(Request $request)
  {
    $paytmParams = array();
    $paytmParams["body"] = array(
      "mid" => $this->mid,
      "orderId" => $request->order_id,
    );
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $this->merchantKey);
    $paytmParams["head"] = array(
      "signature"  => $checksum
    );
    $post_data = json_encode($paytmParams);

    /* for Staging */
    // $url = "https://securegw-stage.paytm.in/v3/order/status";

    /* for Production */
    $url = "https://securegw.paytm.in/v3/order/status";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    $response = json_decode($response);

    $orderDetail = OrderDetail::where('order_id', $request->order_id)->first();

    return response()->json(['orderDetail' => $orderDetail, $response]);
  }

  public function refund(Request $request)
  {
    $check = OrderDetail::where('order_id', $request->orderId)->first();
    if ($check->status == 'Visited') {
      return response()->json(['error' => 'This booking has already visited and could not process refund.']);
    }
    $paytmParams = array();

    $paytmParams["body"] = array(
      "mid"          => $this->mid,
      "txnType"      => "REFUND",
      "orderId"      => $request->orderId,
      "txnId"        => $request->transactionId,
      "refId"        => $request->orderId,
      "refundAmount" => $request->amount,
    );

    /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
    */
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $this->merchantKey);

    $paytmParams["head"] = array(
      "signature" => $checksum
    );

    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

    /* for Staging */
    // $url = "https://securegw-stage.paytm.in/refund/apply";

    /* for Production */
    $url = "https://securegw.paytm.in/refund/apply";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    $response = json_decode($response);
    if ($response->body->resultInfo->resultStatus == "PENDING" || $response->body->resultInfo->resultMsg == "Refund Already Raised") {
      $order = Order::where('order_id', $request->order_id)->first();
      if ($order != null) {
        $order->order_status = 'Refund On Process';
        $order->save();
      }

      $check->payment_status = "Refund On Process";
      $check->status = 'Cancelled';
      $check->save();
    } else if ($response->body->resultInfo->resultMsg == "Refund Already Successful") {
      $order = Order::where('order_id', $request->order_id)->first();
      if ($order != null) {
        $order->order_status = 'Refunded';
        $order->save();
      }

      $check->payment_status = "Refunded";
      $check->status = 'Refunded';
      $check->save();
    }
    return response()->json(['response' => $response]);
  }

  public function refundStatusApi(Request $request)
  {
    $paytmParams = array();
    $paytmParams["body"] = array(
      "mid" => $this->mid,
      "orderId" => $request->order_id,
      "refId" => $request->order_id,
    );
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"]), $this->merchantKey);
    $paytmParams["head"] = array(
      "signature"  => $checksum
    );
    $post_data = json_encode($paytmParams);

    /* for Staging */
    // $url = "https://securegw-stage.paytm.in/v3/order/status";

    /* for Production */
    $url = "https://securegw.paytm.in/v2/refund/status";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    $response = json_decode($response);

    $orderDetail = OrderDetail::where('order_id', $request->order_id)->first();
    if ($orderDetail != null) {
      $orderDetail->payment_status = $response->body->resultInfo->resultCode == 10 ? 'Refund Successful' : 'Refund On Process	';
      $orderDetail->status = 'Cancelled';
      $orderDetail->save();
    }

    $order = Order::where('order_id', $request->order_id)->first();
    if ($order != null) {
      $order->order_status = $response->body->resultInfo->resultCode == 10 ? 'Refund Successful' : 'Refund On Process	';
      $order->save();
    }

    return response()->json(['orderDetail' => $orderDetail, $response]);
  }
}
