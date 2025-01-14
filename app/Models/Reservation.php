<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = ['id'];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    public function reservation_approval() {
        return $this->hasMany(ReservationApproval::class, 'reservation_id');
    }
}
