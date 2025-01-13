<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Risk;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DashRisk extends Controller
{
    public function index(){
        return view('dashboard.risk',[
            "title" => "Dashboard | Lapor daerah rawan banjir",
            "cities" => City::orderBy("name","ASC")->get(),
            "risks" => Risk::whereUserId(auth()->user()->id)->orderBy("id","DESC")->get(),
        ]);
    }

    public function postHandler(Request $request){
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
        }
        else{
            return back()->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        
        $validatedData = $request->validate([
            'city_id'=>'required',
            'title'=>'required',
            'description'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'area'=>'required',
            'date'=>'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        Risk::create($validatedData);
        return ['status'=>'success','message'=>'Laporan berhasil ditambahkan'];
    }

    public function update(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'city_id'=>'required',
            'title'=>'required',
            'description'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'area'=>'required',
            'date'=>'required',
        ]);
        
        $risk = Risk::find($request->id);

        //Check if the data is found
        if(!$risk){
            return ['status'=>'error','message'=>'Laporan tidak ditemukan'];
        }
        
        // Update data
        $risk->update($validatedData);    
        return ['status'=>'success','message'=>'Laporan berhasil diedit'];
        
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $risk = Risk::find($request->id);

        // Check if the data is found
        if (!$risk) {
            return ['status' => 'error', 'message' => 'Laporan tidak ditemukan'];
        }

        Risk::destroy($request->id);
        return ['status' => 'success', 'message' => 'Laporan berhasil dihapus'];
    }

}
