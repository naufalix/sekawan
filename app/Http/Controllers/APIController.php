<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\City;
use App\Models\Activity;
use App\Models\Flood;
use App\Models\FollowUp;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
  
  public function city(City $city){  
    return ApiFormatter::createApi(200,"Success",$city);
  }
  public function activity(Activity $activity){  
    return ApiFormatter::createApi(200,"Success",$activity);
  }
  public function floods(){
    $floods = Flood::with('cause')->get();
    return ApiFormatter::createApi(200, "Success", $floods);
  }
  public function flood($id){
    $flood = Flood::whereId($id)->with('city')->first();  
    return ApiFormatter::createApi(200,"Success",$flood);
  }
  // public function flood(Flood $flood){
  //   return ApiFormatter::createApi(200,"Success",$flood);
  // }
  public function followUp(FollowUp $data){
    return ApiFormatter::createApi(200,"Success",$data);
  }
  public function post(Post $post){  
    return ApiFormatter::createApi(200,"Success",$post);
  }
}
