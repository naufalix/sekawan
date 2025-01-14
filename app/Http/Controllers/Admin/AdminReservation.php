<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use App\Models\Driver;
use App\Models\Reservation;
use App\Models\ReservationApproval;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminReservation extends Controller
{

    public function index(){
        return view('admin.reservation',[
            "title" => "Admin | Reservasi kendaraan",
            "approvers" => Approver::orderBy("name","ASC")->get(),
            "drivers" => Driver::orderBy("name","ASC")->get(),
            "reservations" => Reservation::with('reservation_approval.approver')->orderBy("id","DESC")->get(),
            "approvals" => ReservationApproval::with('approver')->get(),
            "vehicles" => Vehicle::orderBy("name","ASC")->get(),
        ]);
    }

    public function postHandler(Request $request){
        //dd($request);
        if($request->submit=="store"){
            $res = $this->store($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="destroy"){
            $res = $this->softDelete($request);
            return back()->with($res['status'],$res['message']);
            // return back()->with("info","Fitur hapus sementara dinonaktifkan");
        }
    }

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'driver_id'=>'required',
            'vehicle_id'=>'required',
            'purpose'=>'required',
            'approver_1'=>'required',
            'approver_2'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);
        $validatedData['status'] = 'pending';
        
        $reservation = Reservation::create($validatedData);

        ReservationApproval::insert([
            ["approver_id" => $request->approver_1,"reservation_id" => $reservation->id,"approval_level" => 1,"status" => "pending","comment" => "",],
            ["approver_id" => $request->approver_2,"reservation_id" => $reservation->id,"approval_level" => 2,"status" => "pending","comment" => "",]
        ]);

        return ['status'=>'success','message'=>'Reservasi berhasil ditambahkan'];
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'office_id'=>'required',
            'name'=>'required',
            'license_number'=>'required',
            'phone'=>'required',
        ]);
        
        $driver = Reservation::find($request->id);

        //Check if the data is found
        if(!$driver){
            return ['status'=>'error','message'=>'Reservasi tidak ditemukan'];
        }
        
        // Update data
        $driver->update($validatedData);    
        return ['status'=>'success','message'=>'Reservasi berhasil diedit'];
        
    }

    public function softDelete(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $driver = Reservation::find($request->id);
        
        // Check if the data is found
        if (!$driver) {
            return ['status' => 'error', 'message' => 'Reservasi tidak ditemukan'];
        }
        
        $driver->delete();
        return ['status' => 'success', 'message' => 'Reservasi berhasil dihapus'];
    }

}
