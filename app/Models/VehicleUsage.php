<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleUsage extends Model
{
    protected $guarded = ['id'];
    
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
