<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    
    public $table = "driver_info";

    public function attachment(){
        return $this->hasMany(Attachment::class,  'attachment_id', 'attachment_id');
    }
    
}
