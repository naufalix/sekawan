<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminOffice extends Controller
{

    public function index(){
        return view('admin.office',[
            "title" => "Admin | Kantor cabang",
            "offices" => Office::with('driver')->orderBy("name","ASC")->get(),
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
            'name'=>'required',
            'address'=>'required',
        ]);
        
        Office::create($validatedData);

        return ['status'=>'success','message'=>'Kantor cabang berhasil ditambahkan'];
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'address'=>'required',
        ]);
        
        $office = Office::find($request->id);

        //Check if the data is found
        if(!$office){
            return ['status'=>'error','message'=>'Kantor cabang tidak ditemukan'];
        }
        
        // Update data
        $office->update($validatedData);    
        return ['status'=>'success','message'=>'Kantor cabang berhasil diedit']; 
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
        
        $office = Office::find($request->id);
        
        // Check if the data is found
        if (!$office) {
            return ['status' => 'error', 'message' => 'Kantor cabang tidak ditemukan'];
        }

        // Check if has driver
        if ($office->driver->count()>=1) {
            return ['status' => 'error', 'message' => 'Kantor cabang masih memiliki driver'];
        }
        
        $office->delete();
        return ['status' => 'success', 'message' => 'Kantor cabang berhasil dihapus'];
    }

}
