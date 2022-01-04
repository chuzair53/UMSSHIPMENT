<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
  use HasFactory;
  public $table = "shipments";
  protected $guarded = [
    '_token'

  ];
  // public function (Type $var = null)
  // {
  //     # code...
  // }

  public function scopeSearch($query, $filterBy, $filter)
  {
    return $query->where($filterBy, 'like', '%' . $filter . '%');
  }
  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function driver()
  {
    return $this->hasOne(ShipmentToDriver::class, 'shipment_id');
  }
  public function getDriver($id)
  {
    $data =  ShipmentToDriver::where('driver_id', $id)->with('user')->first();
    return $data;
  }

  public function shipper()
  {
    // Here left to do Has Many relation later
    return $this->hasOne(Shipper::class, 'id', 'shipper_id');
  }

  // replace hasMany to hasOne or export csv
  public function package()
  {
    return $this->hasOne(Packages::class, 'shipment_id');
  }

  public function history()
  {
    return $this->hasMany(History::class, 'shipment_id');
  }

}
