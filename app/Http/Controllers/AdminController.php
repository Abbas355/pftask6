<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
   public function login(AdminRequest $request){
    $admin= Admin::where('email',$request->input('email'))->first(); //$request->admin;
    $data="admin not found";
    $status=false;
    if ($admin && Hash::check($request->input('password'), $admin->password)) {
        $admin->remember_token=Str::random(60);
        $admin->save();
        $data=$admin;
        $status=true;
    }
    return response()->pfResponce($data,$status);  
   }
}
