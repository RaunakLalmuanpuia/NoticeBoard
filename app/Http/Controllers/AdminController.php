<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Item;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
  public function getAuthUserDetail()
  {
    return Auth::user();
  }

  public function updateProfile(Request $request)
  {
    // return $request->all();
    // Validator::make($request->all(), [
    //   'name' => 'required',
    //   'email' => 'required|email|unique:admins,email',
    //   'password' => 'required|min:6|confirmed',
    //   'password_confirmation' => 'required',
    // ])->validate();

    $user = User::findOrFail(Auth::id());
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->email != null) {
      $user->password = bcrypt($request->password);
    }
    $user->save();

    return 'ok';
  }

  public function login(Request $request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $user = Auth::user();
      $success['user'] = $user;
      $success['token'] = $user->createToken('thenzawl_golf_resort_token')->accessToken;
      return response()->json($success, 200);
    } else {
      return response()->json(['error' => 'Unauthorised'], 401);
    }
  }

  public function addItem(Request $request)
  {
    $imageName = Str::random(30) . time() . '.' . $request->picture->getClientOriginalExtension();
    $request->picture->move(public_path('itemImages'), $imageName);

    $item = new Item;
    $item->name_of_item = $request->name;
    $item->picture = "itemImages/" . $imageName;
    $item->remark = $request->instruction;
    $item->type = $request->type;
    $item->save();

    foreach ($request->rates as $rates) {
      $rate_decoded = json_decode($rates);
      $rat = new Rate;
      $rat->item_id = $item->id;
      $rat->rate = $rate_decoded->rate;
      $rat->type = $rate_decoded->type;
      $rat->save();
    }
    return response()->json(['success' => 'Item added successfully'], 200);
  }

  public function getItems()
  {
    $items = Item::paginate(10);
    return response()->json(['items' => $items], 200);
  }

  public function getAllItems()
  {
    $items = Item::get();
    return response()->json(['items' => $items], 200);
  }

  public function getVisitorData()
  {
    $newBooking = Order::where('order_status', 'Success')->whereDate('created_at', today())->count();
    $checkin = OrderDetail::where('status', 'Visited')->whereDate('updated_at', today())->count();
    $monthVisitors = OrderDetail::where('status', 'Visited')->whereMonth('updated_at', now()->month)->count();
    return response()->json(['newBooking' => $newBooking, 'checkin' => $checkin, 'monthVisitors' => $monthVisitors]);
  }

  public function getBooked(Request $request)
  {
    if ($request->searchBy == 'period') {
      $orderedItems = OrderedItem::when($request->to, function ($q) use ($request) {
        $q->whereBetween('date_from', [$request->from, $request->to])
          ->whereBetween('date_to', [$request->from, $request->to]);
      })
        ->when(!$request->to, function ($q) use ($request) {
          $q->where('date_from', $request->from);
        })
        ->pluck('order_details_id');
      $orders = OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', today())
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else if ($request->searchBy != 'item') {
      $orders = OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', today())
        ->where($request->searchBy, 'LIKE', '%' . $request->search . '%')
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else {
      $orderedItems = OrderedItem::where('item_id', $request->search)->pluck('order_details_id');
      $orders =
        OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', today())
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    }
    return response()->json(['orders' => $orders], 200);
  }

  public function getHistory(Request $request)
  {
    if ($request->searchBy == 'period') {
      $orderedItems = OrderedItem::when($request->to, function ($q) use ($request) {
        $q->whereBetween('date_from', [$request->from, $request->to])
          ->whereBetween('date_to', [$request->from, $request->to]);
      })
        ->when(!$request->to, function ($q) use ($request) {
          $q->where('date_from', $request->from);
        })
        ->pluck('order_details_id');
      $history = OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', '!=', today())
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else if ($request->searchBy != 'item') {
      $history = OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', '!=', today())
        ->where($request->searchBy, 'LIKE', '%' . $request->search . '%')
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else {
      $orderedItems = OrderedItem::where('item_id', $request->search)->pluck('order_details_id');
      $history = OrderDetail::where('payment_status', 'Success')
        ->whereDate('created_at', '!=', today())
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    }
    return response()->json(['history' => $history], 200);
  }

  public function getRefunds(Request $request)
  {
    if ($request->searchBy == 'period') {
      $orderedItems = OrderedItem::when($request->to, function ($q) use ($request) {
        $q->whereBetween('date_from', [$request->from, $request->to])
          ->whereBetween('date_to', [$request->from, $request->to]);
      })
        ->when(!$request->to, function ($q) use ($request) {
          $q->where('date_from', $request->from);
        })
        ->pluck('order_details_id');
      $history = OrderDetail::where('payment_status', 'LIKE', 'Refund%')
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else if ($request->searchBy != 'item') {
      $history = OrderDetail::where('payment_status', 'LIKE', 'Refund%')
        ->where($request->searchBy, 'LIKE', '%' . $request->search . '%')
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else {
      $orderedItems = OrderedItem::where('item_id', $request->search)->pluck('order_details_id');
      $history = OrderDetail::where('payment_status', 'LIKE', 'Refund%')
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    }
    return response()->json(['refunds' => $history], 200);
  }

  public function getFailedPayments(Request $request)
  {
    if ($request->searchBy == 'period') {
      $orderedItems = OrderedItem::when($request->to, function ($q) use ($request) {
        $q->whereBetween('date_from', [$request->from, $request->to])
          ->whereBetween('date_to', [$request->from, $request->to]);
      })
        ->when(!$request->to, function ($q) use ($request) {
          $q->where('date_from', $request->from);
        })
        ->pluck('order_details_id');
      $failedPayments = OrderDetail::whereIn('payment_status', ['Pending', 'Failure'])
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else if ($request->searchBy != 'item') {
      $failedPayments = OrderDetail::whereIn('payment_status', ['Pending', 'Failure'])
        ->where($request->searchBy, 'LIKE', '%' . $request->search . '%')
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    } else {
      $orderedItems = OrderedItem::where('item_id', $request->search)->pluck('order_details_id');
      $failedPayments = OrderDetail::whereIn('payment_status', ['Pending', 'Failure'])
        ->whereIn('id', $orderedItems)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->paginate);
    }
    return response()->json(['failedPayments' => $failedPayments], 200);
  }

  public function deleteItem($id)
  {
    Item::findOrFail($id)->delete();
    return response()->json(['success' => 'Item Deleted']);
  }
}
