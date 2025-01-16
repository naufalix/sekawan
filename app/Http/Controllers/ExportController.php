<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Driver;
use App\Models\Reservation;
use App\Models\ReservationApproval;
use App\Models\Vehicle;
use App\Models\VehicleUsage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function excel($id){
        if($id=="reservation"){
            return view('export.excel-reservation',[
                "title" => "Data reservasi kandaraan",
                "approvers" => Approver::orderBy("name","ASC")->get(),
                "drivers" => Driver::orderBy("name","ASC")->get(),
                "reservations" => Reservation::with('reservation_approval.approver')->orderBy("id","DESC")->get(),
                "approvals" => ReservationApproval::with('approver')->get(),
                "vehicles" => Vehicle::orderBy("name","ASC")->get(),
            ]);
        }
        else if($id=="vehicle_usage"){
            return view('export.excel-vehicle-usage',[
                "title" => "Data riwayat pemakaian kendaraan",
                "reservations" => Reservation::orderBy("id","DESC")->get(),
                "vehicle_usages" => VehicleUsage::orderBy("id","DESC")->get(),
            ]);
        }else{
            return back()->with(['status'=>'error','message'=>'Data tidak ditemukan']);
        }
    }

}
