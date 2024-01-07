<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  use HasFactory;

  protected $fillable = [
    'status'
  ];

  protected $with = [
    'orderedItem',
    'order',
  ];

  public function orderedItem()
  {
    return $this->hasMany(OrderedItem::class, 'order_details_id');
  }

  public function order()
  {
    return $this->hasOne(Order::class, 'order_id', 'order_id');
  }
    public function orderedItem1()
  {
    return $this->hasOne(OrderedItem::class, 'order_details_id');
  }
}
  

