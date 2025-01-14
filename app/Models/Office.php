<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = ['id'];

    public function driver() {
        return $this->hasMany(Driver::class, 'office_id');
    }
}
