<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function office(){
        return $this->belongsTo(Office::class);
    }
}
