<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Models\Approver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        if(Auth::guard('admin')->check()){ return redirect('/admin/'); }
        if(Auth::guard('approver')->check()){ return redirect('/approver/'); }
        return view('login',[
            "title" => "Sekawan Mine | Login",
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if($request->type=="admin"){
            if(Auth::guard('admin')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/admin/');
            }
            return back()->with('error','Login failed');
        }

        if($request->type=="approver"){
            if(Auth::guard('approver')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/approver/');
            }
            return back()->with('error','Login failed!');
        }

        else{
            return back();
        }
    }

    public function logout(){
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        if(Auth::guard('approver')->check()){
            Auth::guard('approver')->logout();
        }
        return redirect('/login');
    }
}