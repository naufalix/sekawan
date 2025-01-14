<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Auth\CustomAuth as Authenticatable;

class Approver extends Authenticatable
{
    use SoftDeletes;
    protected $guarded = ['id'];
}
