<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Approver;
use App\Models\Driver;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\ReservationApproval;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleUsage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
  
  public function admin(User $admin){  
    return ApiFormatter::createApi(200,"Success",$admin);
  }
  public function approver(Approver $approver){  
    return ApiFormatter::createApi(200,"Success",$approver);
  }
  public function driver(Driver $driver){  
    return ApiFormatter::createApi(200,"Success",$driver);
  }
  public function reservation(Reservation $reservation){  
    return ApiFormatter::createApi(200,"Success",$reservation);
  }
  public function reservation_approval(ReservationApproval $data){  
    return ApiFormatter::createApi(200,"Success",$data);
  }
  public function office(Office $office){  
    return ApiFormatter::createApi(200,"Success",$office);
  }
  public function vehicle(Vehicle $vehicle){  
    return ApiFormatter::createApi(200,"Success",$vehicle);
  }
  public function vehicle_usage(VehicleUsage $data){  
    return ApiFormatter::createApi(200,"Success",$data);
  }
}
