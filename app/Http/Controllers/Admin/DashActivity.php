<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;

class DashActivity extends Controller
{

    public function index(){
        return view('dashboard.activity',[
            "title" => "Dashboard | Kegiatan",
            "activities" => Activity::whereUserId(auth()->user()->id)->orderBy("id","DESC")->get(),
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
            'organizer'=>'required',
            'location'=>'required',
            'description'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'image' => 'required|image|file|max:1024',
            'pic_name'=>'required',
            'phone'=>'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        //Read image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('image'));
        
        // Resize image
        $maxwidth = 800;
        $maxheight = 450;
        if ($image->width() > $image->height()) {
            if ($image->width() > $maxwidth) {
                $newheight = $image->height() / ($image->width() / $maxwidth);
                $image->resize($maxwidth, $newheight);
            }
        } else {
            if ($image->height() > $maxheight) {
                $newwidth = $image->width() / ($image->height() / $maxheight);
                $image->resize($newwidth, $maxheight);
            }
        }

        //Convert to .webp
        $imageWebp = $image->toWebp(100);
        
        // Upload new image
        $validatedData['image'] = time().".webp";
        $imageWebp->save('assets/img/activity/'.$validatedData['image']);
        
        Activity::create($validatedData);
        return ['status'=>'success','message'=>'Kegiatan berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'organizer'=>'required',
            'location'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'image' => 'image|file|max:1024',
            'pic_name'=>'required',
            'phone'=>'required',
        ]);
        
        $activity = Activity::find($request->id);

        //Check if the activity is found
        if(!$activity){
            return ['status'=>'error','message'=>'Kegiatan Budaya tidak ditemukan'];
        }
        
        //Check if has image
        if($request->file('image')){

            // Delete old image
            $image_path = public_path().'/assets/img/activity/'.$activity->image;
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
            
            //Read image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image'));
            
            // Resize image
            $maxwidth = 800;
            $maxheight = 450;
            if ($image->width() > $image->height()) {
                if ($image->width() > $maxwidth) {
                    $newheight = $image->height() / ($image->width() / $maxwidth);
                    $image->resize($maxwidth, $newheight);
                }
            } else {
                if ($image->height() > $maxheight) {
                    $newwidth = $image->width() / ($image->height() / $maxheight);
                    $image->resize($newwidth, $maxheight);
                }
            }

            //Convert to .webp
            $imageWebp = $image->toWebp(100);
            
            // Upload new image
            $validatedData['image'] = $validatedData['id'].'-'.time().".webp";
            $imageWebp->save('assets/img/activity/'.$validatedData['image']);
            
            $activity->update($validatedData);
            return ['status'=>'success','message'=>'Kegiatan berhasil diupdate'];
            
        }else{
            // Update data
            $activity->update($validatedData);    
            return ['status'=>'success','message'=>'Kegiatan berhasil diedit'];
        }
        
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);

        $activity = Activity::find($request->id);

        // Check if the data is found
        if (!$activity) {
            return ['status' => 'error', 'message' => 'Kegiatan tidak ditemukan'];
        }

        $image_path = public_path().'/assets/img/activity/'.$activity->image;

        // Check if the image file exists before attempting to delete it
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }

        Activity::destroy($request->id);
        return ['status' => 'success', 'message' => 'Kegiatan berhasil dihapus'];
    }

}
