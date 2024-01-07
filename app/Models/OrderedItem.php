<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderedItem extends Model
{
    use HasFactory;
    protected $with = [
      'item'
    ];

    public function item()
    {
      return $this->belongsTo(Item::class);
    }

    public function orderDetail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class,'order_details_id');
    }
}
