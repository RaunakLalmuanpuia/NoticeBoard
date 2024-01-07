<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderedItem;
use App\Models\Rate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mail;
use PDF;

class BookingController extends Controller
{
  public function getMyBooking($id)
  {
    $orderDetail = OrderDetail::findOrFail($id);

    return response()->json(['orderDetail' => $orderDetail]);
  }

  public function updateBooking($id, Request $request)
  {
    OrderDetail::findOrFail($id)->update(['status' => $request->status]);
    return response()->json(['success' => 'Status updated']);
  }

  public function deleteBooking($id)
  {
    OrderedItem::where('order_details_id', $id)->delete();
    OrderDetail::findOrFail($id)->delete();
    return response()->json(['success' => 'Order Deleted', 200]);
  }

  public function resendQr(Request $request)
  {
    $orderDetail = OrderDetail::where('order_id', $request->orderId)->first();
    $orderDetail->payment_status = 'Success';
    $orderDetail->save();

    $check = Order::where('order_id', $request->orderId)->first();
    if ($check == null) {
      $order = new Order;
      $order->order_id = $request->orderId;
      $order->tracking_id = $request->tracking_id;
      $order->bank_ref_no = '';
      $order->order_status = 'Success';
      $order->payment_mode = $request->payment_mode;
      $order->card_name = '';
      $order->currency = 'INR';
      $order->amount = $request->amount;
      $order->billing_name = '';
      $order->discount_value = '';
      $order->mer_amount = $request->amount;
      $order->billing_notes = '';
      $order->trans_date = $request->transactionDate;
      $order->save();
    } else {
      $check->order_id = $request->orderId;
      $check->tracking_id = $request->tracking_id;
      $check->bank_ref_no = '';
      $check->order_status = 'Success';
      $check->payment_mode = $request->payment_mode;
      $check->card_name = '';
      $check->currency = 'INR';
      $check->amount = $request->amount;
      $check->billing_name = '';
      $check->discount_value = '';
      $check->mer_amount = $request->amount;
      $check->billing_notes = '';
      $check->trans_date = $request->transactionDate;
      $check->save();
    }
    $this->sendEmail($orderDetail->name, $request->orderId, $orderDetail->email);
    return response()->json(['success' => 'QR Code resend successful']);
  }

  // public function sendEmail($name, $barcode, $email)
  // {
  //   $to_name = $name;
  //   $to_mail = $email;

  //   $detail = OrderDetail::where('order_id', $barcode)->first();
  //   $text = "$detail->name,";
  //   $text .= "$detail->order_id,";
  //   foreach ($detail->orderedItem as $orderedItem) {
  //     $text .= $orderedItem->item->name_of_item . "," . $orderedItem->quantity;
  //   }
  //   $qr = \QrCode::size(500)->generate($text);
  //   $svg = $qr;
  //   $html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="500" height="500" />';
  //   $qr = ['qr' => $html];
  //   view()->share('data', $qr);
  //   $data = array('name' => $name);
  //   $pdf = PDF::loadView('pdf.pdf_view', $data);
  //   Mail::send('emails.booking', $data, function ($message) use ($to_name, $to_mail, $pdf) {
  //     $message->to($to_mail, $to_name)
  //       ->subject('Booking Confirmation')
  //       ->attachData($pdf->output(), 'booking.pdf');
  //     $message->from('noreply@gmail.com', 'Booking Confirmation');
  //   });
  // }
 public function sendEmail($name, $barcode, $email)
    {
        $orderDetail = OrderDetail::where('order_id', $barcode)->first();
        $order = $orderDetail->order;
        $orderItems = $orderDetail->orderedItem1;
        $orderItems1 = OrderedItem::where('order_details_id', $orderDetail->id)->get();


        // Initialize variables to store the item name and rate
        $itemName = '';
        $itemRate = null;

        // Fetch order details and related items
        foreach ($orderItems1 as $orderItem) {
            // Get the Item associated with the OrderItem
            $item = $orderItem->item;

            // Set the item name to the value of 'name_of_item'
            $itemName = $item->name_of_item;

            // Get the rate based on 'type_id' and 'type' column value
            $rate = Rate::where('item_id', $item->id)->where('type', 'Amount')->first();

            if ($rate) {
                // Set the item rate to the rate value
                $itemRate = $rate->rate;
            }
        }
        //qrcode
        $detail = OrderDetail::where('order_id', $barcode)->first();
        $text = "$detail->name,";
        $text .= "$detail->order_id,";
        foreach ($detail->orderedItem as $orderedItem) {
            $text .= $orderedItem->item->name_of_item . "," . $orderedItem->quantity;
        }
        $qr = \QrCode::size(500)->generate($text);
        $svg = $qr;
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" style="width: 110px; height: 110px; margin: 27.5px 5.5px 3.5px 0; object-fit: contain;" />';
        $qr = ['qr' => $html];
        view()->share('data', $qr);



        // Fetch order details and related items
        $data = [
            'name' => $name,
            'order_id' => $order->order_id,
            'order_name' => $orderDetail->name,
            'order_email' => $orderDetail->email,
            'order_contact' => $orderDetail->contact,
            'payment_mode' => $order->payment_mode,
            'mer_amount' => $order->mer_amount,
            'orderDetail' => $orderDetail, 
            'discount_value' => $order->discount_value,
            'amount' => $order->amount,
            'quantity' => $orderItems->quantity,
            'date_from' => $orderItems->date_from,
            'date_to' => $orderItems->date_to,
            'expected_arrival' => $orderItems->expected_arrival,
            'no_of_children' => $orderItems->no_of_children,
            'no_of_adults' => $orderItems->no_of_adult,
            'name_of_item' =>   $itemName,
            'rates' =>  $itemRate,
        ];

        // Generate the PDF with the order details
        $pdf = PDF::loadView('pdf.pdf_view', $data);

        // Send the email
        $to_name = $name;
        $to_mail = $email;

        Mail::send('emails.booking', $data, function ($message) use ($to_name, $to_mail, $pdf) {
            $message->to($to_mail, $to_name)
                ->subject('Booking Confirmation')
                ->attachData($pdf->output(), 'Receipt.pdf');
            $message->from('noreply@gmail.com', 'Booking Confirmation');
        });
    }

  public function createReservation(Request $request)
  {
    Log::info($request->all());

    $orderId = now()->timestamp;
    $path = $this->generateBarcode($orderId);
    $order_detail = new OrderDetail;
    $order_detail->order_id = $orderId;
    $order_detail->name = 'Admin';
    $order_detail->email = 'thenzawlgolfresort@gmail.com';
    $order_detail->contact = '+913892333475';
    $order_detail->barcode = $path;
    $order_detail->payment_status = 'Success';
    $order_detail->save();

    $item = Item::where('name_of_item', 'Log Hut (Day & Night)')->first();

    $ordered_item = new OrderedItem;
    $ordered_item->order_details_id = $order_detail->id;
    $ordered_item->item_id = $item->id;
    $ordered_item->quantity = $request->noOfHuts;
    $ordered_item->date_from = $request->checkIn;
    $ordered_item->date_to = $request->checkOut;
    $ordered_item->expected_arrival = $request->expectedArrival;
    $ordered_item->no_of_children = 0;
    $ordered_item->no_of_adult = 1;
    $ordered_item->save();

    $order = new Order;
    $order->order_id = $orderId;
    $order->tracking_id = $orderId;
    $order->bank_ref_no = '';
    $order->order_status = 'Success';
    $order->payment_mode = 'reservation';
    $order->card_name = '';
    $order->currency = '';
    $order->amount = '';
    $order->billing_name = '';
    $order->discount_value = '';
    $order->mer_amount = '';
    $order->billing_notes = '';
    $order->trans_date = '';
    $order->save();
    return response()->json(['success' => 'Reservation Created Successfully']);
  }

  public function generateBarcode($orderId)
  {
    $imageName = Str::random(30) . date('YmdHis') . '.svg';
    $path = public_path() . '/barcodes/' . $imageName;
    \QrCode::generate($orderId, $path);
    return '/barcodes/' . $imageName;
  }

  public function getReservations()
  {
    $orderIds = Order::where('payment_mode', 'reservation')->pluck('order_id');
    $orderDetail = OrderDetail::whereIn('order_id', $orderIds)->orderBy('created_at', 'DESC')->get();
    return response()->json(['orders' => $orderDetail]);
  }

  public function deleteReservation(Request $request)
  {
    $orderDetail = OrderDetail::where('order_id', $request->id)->first();
    OrderedItem::where('order_details_id', $orderDetail->id)->delete();
    Order::where('order_id', $request->id)->delete();
    $orderDetail->delete();
    return response()->json(['success' => 'Reservation deleted successfully']);
  }
}
