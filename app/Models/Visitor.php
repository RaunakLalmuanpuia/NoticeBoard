<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
  use HasFactory;

  public $timestamps = FALSE;

  protected $fillable = [
    'date',
    'ip'
  ];

  protected $casts = [
    'date' => 'datetime:Y-m-d',
  ];
}
