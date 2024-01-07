<?php

namespace App\Http\Controllers;

use PDF;
use Mail;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Rate;
use App\Models\Guide;
use App\Models\Category;
use App\Models\NewsEvent;
use App\Models\OrderDetail;
use App\Models\OrderedItem;
use Illuminate\Http\Request;
use App\Models\PlaceOfInterest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder;

class CustomerController extends Controller
{
    public function getGuideList($category)
    {
        $category = Category::where('name', $category)->first();
        $guides = Guide::where('category_id', $category->id)->orderBy('id', 'DESC')->paginate(6);
        return response()->json(['guides' => $guides], 200);
    }

    public function placeOfInterest()
    {
        $placeOfInterest = PlaceOfInterest::paginate(16);
        $result = $placeOfInterest->toArray();
        $chunk = $placeOfInterest->chunk(4);
        return response()->json(['placeOfInterest' => $chunk, 'last_page' => $result['last_page'], 'current_page' => $result['current_page']], 200);
    }

    public function getOffers()
    {
        $offers = Item::with('rate')->get();
        $bookings = Item::where('type', 'display')->with('rate')->get();
        $addons = Item::where('type', 'addon')->with('rate')->get();
        return response()->json(['offers' => $offers, 'bookings' => $bookings, 'addons' => $addons], 200);
    }

    public function singleOffer($id)
    {
        $offer = Item::with('rate')->with('discount')->findOrFail($id);
        return response()->json(['offer' => $offer], 200);
    }

    public function getOrderDetail($id)
    {
        $decrypt = Crypt::decryptString($id);
        if ($decrypt == 'error') {
            $message = 'Last transaction failed. Please try gain';
            $status = 'Failure';
            return response()->json(['status' => $status, 'message' => $message], 200);
        }
        $detail = OrderDetail::findOrFail($decrypt)->only('order_id', 'payment_status', 'barcode', 'email', 'name', 'contact');
        $status = $detail['payment_status'];
        if ($status == 'Success') {
            $message = 'Your order is successful';
            $barcode = $detail['order_id'];
            $this->sendEmail($detail['name'], $barcode, $detail['email']);
            return response()->json(['status' => $status, 'message' => $message], 200);
        } elseif ($detail['payment_status'] == 'Failure') {
            $message = 'Last transaction failed. Please try again';
            return response()->json(['status' => $status, 'message' => $message], 200);
        } elseif ($detail['payment_status'] == 'Aborted') {
            $message = 'The transaction was aborted.';
            return response()->json(['status' => $status, 'message' => $message], 200);
        }
    }

    // public function sendEmail($name, $barcode, $email)
    // {
    //     $to_name = $name;
    //     $to_mail = $email;

    //     $detail = OrderDetail::where('order_id', $barcode)->first();
    //     $text = "$detail->name,";
    //     $text .= "$detail->order_id,";
    //     foreach ($detail->orderedItem as $orderedItem) {
    //         $text .= $orderedItem->item->name_of_item . "," . $orderedItem->quantity;
    //     }
    //     $qr = \QrCode::size(500)->generate($text);
    //     $svg = $qr;
    //     $html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="500" height="500" />';
    //     $qr = ['qr' => $html];
    //     view()->share('data', $qr);
    //     $data = array('name' => $name);
    //     $pdf = PDF::loadView('pdf.pdf_view', $data);
    //     Mail::send('emails.booking', $data, function ($message) use ($to_name, $to_mail, $pdf) {
    //         $message->to($to_mail, $to_name)
    //             ->subject('Booking Confirmation')
    //             ->attachData($pdf->output(), 'booking.pdf');
    //         $message->from('noreply@gmail.com', 'Booking Confirmation');
    //     });
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
    

    public function getBarcode()
    {
        return view('barcode');
    }

    public function getNews()
    {
        $news = NewsEvent::latest()->take(5)->get();
        return response()->json(['news' => $news], 200);
    }

    public function scanQrCode(Request $request)
    {
        $order = OrderDetail::where('order_id', $request->order_id)->first();
        if ($order != null) {
            $item = OrderedItem::where('order_details_id', $order->id)->first();
        }
        $today = date("Y-m-d");
        if ($order == null) {
            return response()->json(['order' => 'Invalid QR Code'], 200);
        } else if ($order->status == 'Visited') {
            return response()->json(['order' => 'You have already visited using this QR Code. Please make new booking'], 200);
        } else if ($order->payment_status != 'Success') {
            return response()->json(['order' => 'There was a problem in your payment'], 200);
        } else if ($item->date_from != $today) {
            return response()->json(['order' => "Your booking date is on $item->date_from. Please come again."], 200);
        } else if ($order->payment_status == 'Success' && $order->status == 'Not Visited') {
            $order->status = 'Visited';
            $order->save();
        }
        return response()->json(['order' => 'QR Code Valid! You may now enter'], 200);
    }

    public function getPlaceOfInterest()
    {
        $placeOfInterest = PlaceOfInterest::inRandomOrder()->limit(4)->get();
        return response()->json(['placeOfInterests' => $placeOfInterest], 200);
    }

    public function messageReply(Request $request)
    {
        return response()->json(['request' => $request->all()]);
    }

    public function checkDate(Request $request)
    {
        //change the number of huts
        $no_of_huts = 27;
        $item = Item::findOrFail($request->type);
        switch ($item->name_of_item) {
            case 'Convention Hall':
                $orders = OrderedItem::where('item_id', $item->id)->where('date_from', $request->date)->sum('quantity');
                if ($orders != 0) {
                    $ordersCheck = OrderedItem::where('item_id', $item->id)->where('date_from', $request->date)->first();
                    $orderDetails = OrderDetail::where('id', $ordersCheck->order_details_id)->first();
                    if ($orderDetails->payment_status == 'Success') {
                        return response()->json(['message' => 'Convention Hall is not available for the selected date']);
                    } else {
                        return response()->json(['message' => 'Convention Hall is available for the selected date']);
                    }
                } else {
                    return response()->json(['message' => 'Convention Hall is available for the selected date']);
                }
                break;

            case 'Log Hut (Day)':
                $hut = Item::query()
                    ->whereIn('name_of_item', ['Log Hut (Day)', 'Log Hut (Day & Night)'])
                    ->pluck('id');

                $bookedCount = OrderedItem::query()
                    ->whereIn('item_id', $hut)
                    ->whereBetween('date_from', [$request->date_from, $request->date_to])
                    ->whereBetween('date_to', [$request->date_from, $request->date_to])
                    ->whereHas('orderDetail',function (Builder $builder){
                        return $builder->where('payment_status', 'Success');
                    })
                    ->sum('quantity');

                info('booked hut =>'.$bookedCount);
                $datediff = strtotime($request->date_from) - strtotime($request->date_to);
                $no_of_days = (round($datediff / (60 * 60 * 24))) * -1;
                if ($no_of_days == 0) {
                    $no_of_days = 1;
                }
                if ($bookedCount >= $no_of_huts) {
                    return response()->json(['message' => 'No more huts available for this date.', 'no_of_days' => $no_of_days]);
                } else {
                    return response()->json(['message' => ' Huts Available', 'hutsAvailable' => $no_of_huts - $bookedCount, 'no_of_days' => $no_of_days]);
                }
            case 'Wellness Log':
                $availableHut=15;
                $hut = Item::query()
                    ->where('name_of_item', 'Wellness Log')
                    ->pluck('id');
                $bookedCount = OrderedItem::query()
                    ->whereIn('item_id', $hut)
                    ->whereBetween('date_from', [$request->date_from, $request->date_to])
                    ->whereBetween('date_to', [$request->date_from, $request->date_to])
                    ->whereHas('orderDetail',function (Builder $builder){
                        return $builder->where('payment_status', 'Success');
                    })
                    ->sum('quantity');

                $datediff = strtotime($request->date_from) - strtotime($request->date_to);
                $no_of_days = (round($datediff / (60 * 60 * 24))) * -1;
                if ($no_of_days == 0) {
                    $no_of_days = 1;
                }
                if ($bookedCount >= $no_of_huts) {
                    return response()->json(['message' => 'No more huts available for this date.', 'no_of_days' => $no_of_days]);
                } else {
                    return response()->json(['message' => ' Huts Available', 'hutsAvailable' => $no_of_huts - $bookedCount, 'no_of_days' => $no_of_days]);
                }

            case 'Log Hut (Day & Night)':
                $hut = Item::whereIn('name_of_item', ['Log Hut (Day)', 'Log Hut (Day & Night)'])->pluck('id');
                $newBookingStartDate = date('Y-m-d', strtotime($request->date_from));
                $newBookingEndDate = date('Y-m-d', strtotime($request->date_to));

                $bookedQuantities = OrderedItem::query()
                    ->whereIn('item_id', $hut)
                    ->whereHas('orderDetail', function (Builder $builder) {
                        return $builder->where('payment_status', 'Success');
                    })
                    ->where(function ($query) use ($newBookingStartDate, $newBookingEndDate) {
                        $query->whereBetween('date_from', [$newBookingStartDate, $newBookingEndDate])
                            ->orWhereBetween('date_to', [$newBookingStartDate, $newBookingEndDate])
                            ->orWhere(function ($q) use ($newBookingStartDate, $newBookingEndDate) {
                                $q->where('date_from', '<=', $newBookingStartDate)
                                    ->where('date_to', '>=', $newBookingEndDate);
                            });
                    })
                    ->get(['id', 'date_from', 'date_to', 'quantity'])
                    ->unique('id')
                    ->toArray();

                // Filter out entries where $newBookingEndDate is the same as date_from
                $bookedQuantities = array_filter($bookedQuantities, function ($booking) use ($newBookingEndDate) {
                    return $booking['date_from'] !== $newBookingEndDate;
                });
                // Filter out entries where $newBookingStartDate is the same as date_to
                $bookedQuantities = array_filter($bookedQuantities, function ($booking) use ($newBookingStartDate) {
                    return $booking['date_to'] !== $newBookingStartDate;
                });

                // Get the sum of all quantities
                $totalQuantityBooked = array_sum(array_column($bookedQuantities, 'quantity'));

                $datediff = strtotime($request->date_from) - strtotime($request->date_to);
                $no_of_days = (round($datediff / (60 * 60 * 24))) * -1;
                if ($no_of_days == 0) {
                    $no_of_days = 1;
                }

                // return response()->json(['message' => 'Huts Available', 'hutsAvailable' => $bookedQuantities, 'no_of_days' => $no_of_days]);
                
                if ($totalQuantityBooked >= $no_of_huts) {
                    return response()->json(['message' => 'No more huts available for this date.']);
                } else {
                    return response()->json(['message' => 'Huts Available', 'hutsAvailable' => $no_of_huts - $totalQuantityBooked, 'no_of_days' => $no_of_days]);
                }

                // $bookedCount = OrderedItem::query()
                //     ->whereIn('item_id', $hut)
                //     ->whereBetween('date_from', [$request->date_from, $request->date_to])
                //     ->whereBetween('date_to', [$request->date_from, $request->date_to])
                //     ->whereHas('orderDetail',function (Builder $builder){
                //         return $builder->where('payment_status', 'Success');
                //     })
                //     ->sum('quantity');

                // $datediff = strtotime($request->date_from) - strtotime($request->date_to);
                // $no_of_days = (round($datediff / (60 * 60 * 24))) * -1;
                // if ($no_of_days == 0) {
                //     $no_of_days = 1;
                // }
                // if ($bookedCount >= $no_of_huts) {
                //     return response()->json(['message' => 'No more huts available for this date.']);
                // } else {
                //     return response()->json(['message' => ' Huts Available', 'hutsAvailable' => $no_of_huts - $bookedCount, 'no_of_days' => $no_of_days]);
                // }

                break;
        }
    }

    public function getCrypt(Request $request)
    {
        $encrypted = Crypt::encryptString($request->id);
        return $encrypted;
    }
}
