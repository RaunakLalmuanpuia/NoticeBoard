<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
  private $working_key = 'D5482F4525907514AAED0031F3131865';
  private $access_code = 'AVJT09IF91AU01TJUA';
  private $merchant_id = '398454';

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

    $merchant_data = '';
    $merchant_data .= 'order_id=' . $order_detail->order_id . '&';
    $merchant_data .= 'merchant_id=' . $this->merchant_id . '&';

    // $merchant_data.='redirect_url=http://localhost:8000/api/response-handler&';
    // $merchant_data.='cancel_url=http://localhost:8000/api/response-handler&';

    $merchant_data .= 'redirect_url=https://thenzawlgolfresort.com/api/response-handler&';
    $merchant_data .= 'cancel_url=https://thenzawlgolfresort.com/api/response-handler&';

    foreach ($request->all() as $key => $value) {
      if ($key != 'addons') {
        $merchant_data .= $key . '=' . $value . '&';
      }
    }

    if ($request->no_of_days) {
      $no_of_days = $request->no_of_days;
    } else {
      $no_of_days = 1;
    }

    $merchant_data .= 'currency=INR&';
    $merchant_data .= 'language=EN&';
    $merchant_data .= 'billing_notes=' . $order_detail->id;

    $encrypted_data = $this->encrypt($merchant_data, $this->working_key);

    return response()->json([
      'ss' => $order_detail->id,
      "encrypted_data" => $encrypted_data,
      "access_code" => $this->access_code,
      "no_of_days" => $no_of_days,
    ], 201);
  }

  public function responseHandler(Request $request)
  {
    $encResponse = $request->encResp;
    $rcvdString = $this->decrypt($encResponse, $this->working_key);
    $order_status = "";
    $decryptValues = explode('&', $rcvdString);
    $dataSize = sizeof($decryptValues);

    for ($i = 0; $i < $dataSize; $i++) {
      $information = explode('=', $decryptValues[$i]);
      if ($i == 0)
        $order_id = $information[1];
      if ($i == 1)
        $tracking_id = $information[1];
      if ($i == 2)
        $bank_ref_no = $information[1];
      if ($i == 3)
        $order_status = $information[1];
      if ($i == 5)
        $payment_mode = $information[1];
      if ($i == 6)
        $card_name = $information[1];
      if ($i == 9)
        $currency = $information[1];
      if ($i == 10)
        $amount = $information[1];
      if ($i == 11)
        $billing_name = $information[1];
      if ($i == 34)
        $discount_value = $information[1];
      if ($i == 35)
        $mer_amount = $information[1];
      if ($i == 39)
        $billing_notes = $information[1];
      if ($i == 40)
        $trans_date = $information[1];
    }

    $check = Order::where('order_id', $order_id)->where('tracking_id', $tracking_id)->first();
    if ($check == null) {
      $order = new Order;
      $order->order_id = $order_id;
      $order->tracking_id = $tracking_id;
      $order->bank_ref_no = $bank_ref_no;
      $order->order_status = $order_status;
      $order->payment_mode = $payment_mode;
      $order->card_name = $card_name;
      $order->currency = $currency;
      $order->amount = $amount;
      $order->billing_name = $billing_name;
      $order->discount_value = $discount_value;
      $order->mer_amount = $mer_amount;
      $order->billing_notes = $billing_notes;
      $order->trans_date = $trans_date;
      $order->save();

      $details = OrderDetail::findOrFail($order->billing_notes);
      $details->order_id = $order->order_id;
      $details->payment_status = $order->order_status;
      if ($order->order_status == 'Success') {
        $path = $this->generateBarcode($order->order_id);
        $details->barcode = $path;
      }
      $details->save();

      if ($details->order_id != $order->order_id) {
        $order->order_status = 'Failure';
        $order->save();
      }

      $encrypted = Crypt::encryptString($details->id);

      $redirectURL = '/order-complete/' . $encrypted;

      return redirect($redirectURL);
    } else {
      $encrypted = Crypt::encryptString('error');

      $redirectURL = '/order-complete/' . $encrypted;

      return redirect($redirectURL);
    }
  }

  public function generateBarcode($orderId)
  {
    // $image_64 = \DNS1D::getBarcodePNG($orderId, 'C39');
    $imageName = \Str::random(30) . date('YmdHis') . '.svg';
    $path = public_path() . '/barcodes/' . $imageName;
    // $success = file_put_contents($path, base64_decode($image_64));
    \QrCode::generate($orderId, $path);
    return '/barcodes/' . $imageName;
  }

  public function apiTest(Request $request)
  {
    // $order = Order::where('order_id', $request->tracking_id)->first();
    $merchant_json_data =
      array(
        'reference_no' => $request->tracking_id,
      );

    $merchant_data = json_encode($merchant_json_data);
    $encrypted_data = $this->encrypt($merchant_data, $this->working_key);

    $client = new \GuzzleHttp\Client();
    $body[] = $encrypted_data;
    $url = "https://logintest.ccavenue.com/apis/servlet/DoWebTrans?enc_request=" . $encrypted_data . "&access_code=" . $this->access_code . "&request_type=JSON&response_type=STRING&command=orderStatusTracker&version=1.2";

    $response = $client->request("POST", $url);

    // dd($response->getBody()->read(40000));

    $decrypted_data = $this->decrypt($encrypted_data, $this->working_key);
    $response_body = $response->getBody()->read(40000);
    $split = explode('&', $response_body);
    $split = explode('=', $split[1]);
    $str = preg_replace("/[\n\r]/", "", $split[1]);
    $decrypted_response = $this->decrypt($str, $this->working_key);

    $data = [
      'encryptedresponse' => $response_body,
      'decrypted_response' => $decrypted_response,
    ];
    dd($data);
  }


  // CRYPTO
  public function encrypt($plainText, $key)
  {
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
  }

  public function decrypt($encryptedText, $key)
  {
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = $this->hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
  }
  //*********** Padding Function *********************

  public function pkcs5_pad($plainText, $blockSize)
  {
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
  }

  //********** Hexadecimal to Binary function for php 4.0 version ********

  public function hextobin($hexString)
  {
    $length = strlen($hexString);
    $binString = "";
    $count = 0;
    while ($count < $length) {
      $subString = substr($hexString, $count, 2);
      $packedString = pack("H*", $subString);
      if ($count == 0) {
        $binString = $packedString;
      } else {
        $binString .= $packedString;
      }

      $count += 2;
    }
    return $binString;
  }
}
