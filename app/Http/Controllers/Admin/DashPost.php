<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;

class DashPost extends Controller
{

    public function index(){
        return view('dashboard.post',[
            "title" => "Dashboard | Artikel Edukasi",
            "posts" => Post::whereUserId(auth()->user()->id)->orderBy("id","DESC")->get(),
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
            'title'=>'required',
            'slug'=>'required',
            'body'=>'required',
            'writer'=>'required',
            'image' => 'required|image|file|max:1024',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        //Check duplicate slug
        if(Post::whereSlug($request->slug)->first()){
            return ['status'=>'error','message'=>'Judul telah terpakai'];
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
        $validatedData['image'] = time().".webp";
        $imageWebp->save('assets/img/post/'.$validatedData['image']);
        
        Post::create($validatedData);
        return ['status'=>'success','message'=>'Artikel berhasil ditambahkan'];

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'title'=>'required',
            'slug'=>'required',
            'body'=>'required',
            'writer'=>'required',
            'image' => 'image|file|max:1024',
        ]);
        
        $post = Post::find($request->id);

        //Check if the data is found
        if(!$post){
            return ['status'=>'error','message'=>'Artikel tidak ditemukan'];
        }

        // Check if the slug is different from before
        if($post->slug!=$request->slug){
            // Check if the slug has not been used
            if(Post::whereSlug($request->slug)->first()){
                return ['status'=>'error','message'=>'Slug telah terpakai'];
            }
        }
        
        //Check if has image
        if($request->file('image')){

            // Delete old image
            $image_path = public_path().'/assets/img/post/'.$post->image;
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
            
            //Read image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image'));
            
            // Resize image
            $maxwidth = 800;
            if ($image->width() > $maxwidth) {
                $maxheight = $image->height()/($image->width()/$maxwidth);
                $image->resize($maxwidth, $maxheight);
            }

            //Convert to .webp
            $imageWebp = $image->toWebp(100);
            
            // Upload new image
            $validatedData['image'] = time().".webp";
            $imageWebp->save('assets/img/post/'.$validatedData['image']);
            
            $post->update($validatedData);
            return ['status'=>'success','message'=>'Post berhasil diupdate'];
            
        }else{
            // Update data
            $post->update($validatedData);    
            return ['status'=>'success','message'=>'Post berhasil diedit'];
        }
        
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);

        $post = Post::find($request->id);

        // Check if the data is found
        if (!$post) {
            return ['status' => 'error', 'message' => 'Artikel tidak ditemukan'];
        }

        $image_path = public_path().'/assets/img/post/'.$post->image;

        // Check if the image file exists before attempting to delete it
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }

        Post::destroy($request->id);
        return ['status' => 'success', 'message' => 'Artikel berhasil dihapus'];
    }

}
