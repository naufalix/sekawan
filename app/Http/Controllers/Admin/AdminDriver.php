<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Office;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminDriver extends Controller
{

    public function index(){
        return view('admin.driver',[
            "title" => "Admin | Driver",
            "drivers" => Driver::orderBy("name","ASC")->get(),
            "offices" => Office::orderBy("name","ASC")->get(),
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
            'office_id'=>'required',
            'name'=>'required',
            'license_number'=>'required',
            'phone'=>'required',
        ]);
        
        Driver::create($validatedData);
        return ['status'=>'success','message'=>'Driver berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'office_id'=>'required',
            'name'=>'required',
            'license_number'=>'required',
            'phone'=>'required',
        ]);
        
        $driver = Driver::find($request->id);

        //Check if the data is found
        if(!$driver){
            return ['status'=>'error','message'=>'Driver tidak ditemukan'];
        }
        
        // Update data
        $driver->update($validatedData);    
        return ['status'=>'success','message'=>'Driver berhasil diedit'];
        
    }

    public function softDelete(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $driver = Driver::find($request->id);
        
        // Check if the data is found
        if (!$driver) {
            return ['status' => 'error', 'message' => 'Driver tidak ditemukan'];
        }
        
        $driver->delete();
        return ['status' => 'success', 'message' => 'Driver berhasil dihapus'];
    }

}
