<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $with = [
      'rate',
    ];
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
