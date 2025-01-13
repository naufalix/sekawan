<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;

class DashUser extends Controller
{

    public function index(){
        return view('dashboard.profile',[
            "title" => "Dashboard | Profil",
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

    public function update(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'username'=>'required',
            'email'=>'required',
            'type'=>'required',
            'location'=>'required',
            'phone'=>'required',
            'description'=>'required',
            'image' => 'image|file|max:1024',
        ]);
        
        $user = User::find(auth()->user()->id);

        //Check if the data is found
        if(!$user){
            return ['status'=>'error','message'=>'Data tidak ditemukan'];
        }

        //Check password
        if($request->password){
            $validatedData['password'] = Hash::make($request->password);
        }else{
            $validatedData['password'] = $user->password;
        }

        // Check Email
        if ($request->email !== $user->email && User::where('email', $request->email)->exists()) {
            return ['status' => 'error', 'message' => 'Email telah terpakai'];
        }

        // Check Username
        if ($request->username !== $user->username && User::where('username', $request->username)->exists()) {
            return ['status' => 'error', 'message' => 'Username telah terpakai'];
        }
        
        //Check if has image
        if($request->file('image')){

            // Delete old image
            if(!empty($user->image)){
                $image_path = public_path().'/assets/img/user/'.$user->image;
                if (file_exists($image_path)) {
                    unlink($image_path); // Delete the image file
                }
            }
            
            //Read image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image'));
            
            // Resize image
            $maxwidth = 300;
            $maxheight = 300;
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
            $imageWebp->save('assets/img/user/'.$validatedData['image']);
            
            $user->update($validatedData);
            return ['status'=>'success','message'=>'Data berhasil diupdate'];
            
        }else{
            // Update data
            $user->update($validatedData);    
            return ['status'=>'success','message'=>'Data berhasil diedit'];
        }
        
    }

}
