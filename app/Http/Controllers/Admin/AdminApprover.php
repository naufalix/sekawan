<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Approver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminApprover extends Controller
{

    public function index(){
        return view('admin.approver',[
            "title" => "Admin | Approver",
            "approvers" => Approver::orderBy("name","ASC")->get(),
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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone'=>'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check Email
        if(Approver::whereEmail($request->email)->first()){
            return ['status'=>'error','message'=>'Email telah terpakai'];
        }
        
        Approver::create($validatedData);
        return ['status'=>'success','message'=>'Approver berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);
        
        $approver = Approver::find($request->id);
 
        //Check if the data is found
        if(!$approver){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }

        //Check password
        if($request->password){
            $validatedData['password'] = Hash::make($request->password);
        }else{
            $validatedData['password'] = $approver->password;
        }

        // Check Email
        if ($request->email !== $approver->email && Approver::where('email', $request->email)->exists()) {
            return ['status' => 'error', 'message' => 'Email telah terpakai'];
        }

        // Update data
        $approver->update($validatedData);    
        return ['status'=>'success','message'=>'Approver berhasil diedit'];
    }

    public function softDelete(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $approver = Approver::find($request->id);
        
        // Check if the data is found
        if (!$approver) {
            return ['status' => 'error', 'message' => 'Approver tidak ditemukan'];
        }
        
        $approver->delete();
        return ['status' => 'success', 'message' => 'Approver berhasil dihapus'];
    }

}
