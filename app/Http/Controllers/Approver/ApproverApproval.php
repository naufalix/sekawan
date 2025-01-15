<?php

namespace App\Http\Controllers\Approver;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationApproval;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ApproverApproval extends Controller
{

    public function index(){
        $approver_id = auth()->user()->id;
        return view('approver.approval',[
            "title" => "Dashboard | Persetujuan reservasi",
            "approvals" => ReservationApproval::where('approver_id',$approver_id)->orderBy("id","DESC")->get(),
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="update"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'status'=>'required',
            'comment'=>'required',
        ]);
        
        $approval = ReservationApproval::find($request->id);
        
        //Check if the data is found
        if(!$approval){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }

        // Update data
        $approval->update($validatedData); 
        
        // Update reservation status
        $reservation = Reservation::find($approval->reservation_id);

        $approval1 = $reservation->reservation_approval->where('approval_level',1)->first();
        $approval2 = $reservation->reservation_approval->where('approval_level',2)->first();
        
        if($approval1->status=='rejected'||$approval2->status=='rejected'){
            $reservation->status='rejected';
            $reservation->save(); 
        }
        else if($approval1->status=='approved' && $approval2->status=='approved'){
            $reservation->status='approved';
            $reservation->save(); 
        }
        else{
            $reservation->status='pending';
            $reservation->save();
        }
        
        
        return ['status'=>'success','message'=>'Data berhasil diedit'];
        
    }

}
