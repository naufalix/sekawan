<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationApproval extends Model
{
    protected $guarded = ['id'];

    public function approver(){
        return $this->belongsTo(Approver::class);
    }
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
