<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminAdmin extends Controller
{

    public function index(){
        return view('admin.admin',[
            "title" => "Admin | Admin management",
            "admins" => User::orderBy("name","ASC")->get(),
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
        if(User::whereEmail($request->email)->first()){
            return ['status'=>'error','message'=>'Email telah terpakai'];
        }
        
        User::create($validatedData);
        return ['status'=>'success','message'=>'Admin berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);
        
        $admin = User::find($request->id);
 
        //Check if the data is found
        if(!$admin){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }

        //Check password
        if($request->password){
            $validatedData['password'] = Hash::make($request->password);
        }else{
            $validatedData['password'] = $admin->password;
        }

        // Check Email
        if ($request->email !== $admin->email && User::where('email', $request->email)->exists()) {
            return ['status' => 'error', 'message' => 'Email telah terpakai'];
        }

        // Update data
        $admin->update($validatedData);    
        return ['status'=>'success','message'=>'Admin berhasil diedit'];
    }

    public function softDelete(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $admin = User::find($request->id);
        
        // Check if the data is found
        if (!$admin) {
            return ['status' => 'error', 'message' => 'Admin tidak ditemukan'];
        }
        
        $admin->delete();
        return ['status' => 'success', 'message' => 'Admin berhasil dihapus'];
    }

}
