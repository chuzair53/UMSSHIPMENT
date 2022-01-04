<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentToDriver extends Model
{
    protected $guarded = [
      ''
    ];
    use HasFactory;

    public function shipment()
    {
        return $this->hasMany(Shipment::class, 'id', 'shipment_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'driver_id');
    }
    public function driverInfo()
    {
        return $this->hasOne(Driver::class, 'shipment_id', 'shipment_id');
    }
   
    
}
