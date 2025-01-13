<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Flood;
use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;

class DashFollowUp extends Controller
{

    public function index(){
        return view('dashboard.follow-up',[
            "title" => "Dashboard | Tindak lanjut laporan",
            "floods" => Flood::whereStatus(0)->orderBy("id","DESC")->get(),
            "followups" => FollowUp::whereUserId(auth()->user()->id)->orderBy("id","DESC")->get(),
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
            'flood_id'=>'required',
            'name'=>'required',
            'type'=>'required',
            'description'=>'required',
        ]);
        $validatedData['point'] = 1;
        $validatedData['user_id'] = auth()->user()->id;

        // Create data
        FollowUp::create($validatedData);

        // Update user point
        $user = User::find(auth()->user()->id);
        $user->point += 1;
        $user->save();

        // Update flood status
        $flood = Flood::find($request->flood_id);
        $flood->status = 1;
        $flood->save();

        return ['status'=>'success','message'=>'Data berhasil ditambahkan'];
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'type'=>'required',
            'description'=>'required',
        ]);
        
        $fup = FollowUp::find($request->id);

        //Check if the data is found
        if(!$fup){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }

        // Update data
        $fup->update($validatedData);
        return ['status'=>'success','message'=>'Data berhasil diedit'];
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);

        $fup = FollowUp::find($request->id);

        // Check if the data is found
        if (!$fup) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }

        // Update user point
        $user = User::find(auth()->user()->id);
        $user->point -= 1;
        $user->save();

        // Update flood status
        $flood = Flood::find($fup->flood_id);
        if (!$fup) {
            $flood->status = 0;
            $flood->save();
        }

        // Delete data
        FollowUp::destroy($request->id);

        return ['status' => 'success', 'message' => 'Data berhasil dihapus'];
    }

}
