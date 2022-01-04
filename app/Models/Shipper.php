<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;
    protected $guarded = [
        '_token'
     
    ];
    public $table = "shipper";

    public function scopeSearch($query, $filterBy, $filter)
    {
        return $query->where($filterBy, 'like', '%' . $filter . '%');
    }
}
