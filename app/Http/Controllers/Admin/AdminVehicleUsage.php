<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\VehicleUsage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminVehicleUsage extends Controller
{

    public function index(){
        return view('admin.vehicle-usage',[
            "title" => "Admin | Riwayat pemakaian kendaraan",
            "reservations" => Reservation::orderBy("id","DESC")->get(),
            "vehicle_usages" => VehicleUsage::orderBy("id","DESC")->get(),
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
            $res = $this->destroy($request);
            return back()->with($res['status'],$res['message']);
            // return back()->with("info","Fitur hapus sementara dinonaktifkan");
        }
    }

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'reservation_id'=>'required',
            'distance_covered'=>'required',
            'fuel_used'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ]);

        $reservation = Reservation::find($request->reservation_id);
        $validatedData['vehicle_id'] = $reservation->vehicle_id;

        VehicleUsage::create($validatedData);
        return ['status'=>'success','message'=>'Riwayat pemakaian berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'reservation_id'=>'required',
            'distance_covered'=>'required',
            'fuel_used'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ]);
        
        $reservation = Reservation::find($request->reservation_id);
        $validatedData['vehicle_id'] = $reservation->vehicle_id;
        
        $vu = VehicleUsage::find($request->id);
        
        //Check if the data is found
        if(!$vu){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }
        
        // Update data
        $vu->update($validatedData);    
        return ['status'=>'success','message'=>'Data berhasil diedit'];
        
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $vu = VehicleUsage::find($request->id);
        
        // Check if the data is found
        if (!$vu) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }
        
        $vu->delete();
        return ['status' => 'success', 'message' => 'Data berhasil dihapus'];
    }

}
