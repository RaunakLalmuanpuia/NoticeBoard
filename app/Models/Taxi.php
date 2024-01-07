<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    const TYPE = [
        'AUTO' => 'auto',
        'TAXI' => 'taxi',
    ];
    protected $fillable = ['owner', 'contact','auto', 'registration_no', 'address'];
}
