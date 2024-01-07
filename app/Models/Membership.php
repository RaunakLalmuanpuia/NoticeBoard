<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory, Notifiable;
    public function routeNotificationForWhatsapp()
    {
      return $this->contact;
    }
}
