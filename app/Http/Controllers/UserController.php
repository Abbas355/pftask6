<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignupUserRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\VerfiUserEmail;
use App\Models\Token;
 use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(SignupUserRequest $request){
        $photo=$this->getImagePath($request);
        $request->merge([ 'photo' => $photo ]);
        $user=User::create($request->only(['first_name','last_name','password','email','status','date_of_birth','bio','gender','address','phoneNumber','photo']));
        $tokenLink=route('verfiy', [$user->id,sha1($user->email)]);
        SendEmailJob::dispatch(['email'=>$request->email,'tokenlink'=>$tokenLink,'subject'=>"Verify Email"]); 
        DB::table('password_resets')->insert(['email' => $user->email,'token' => sha1($user->email),'created_at' => Carbon::now()]);
        $user->remember_token=Str::random(40);
        $user->save();
        $user->tokens()->create(['token' => $user->remember_token]);
        return response()->pfResponce($user,true);   //using a  macro response 
    }

    // public function add(SignupUserRequest $request){
    //     $photo=$this->getImagePath($request);
    //     $request->merge([ 'photo' => $photo ]);
    //     $user=User::create($request->only(['name','password','email','photo']));
    //     $tokenLink=route('verfiy', [$user->id,sha1($user->email)]);
    //     SendEmailJob::dispatch(['email'=>$request->email,'tokenlink'=>$tokenLink,'subject'=>"Verify Email"]); 
    //     DB::table('password_resets')->insert(['email' => $user->email,'token' => sha1($user->email),'created_at' => Carbon::now()]);
    //     return response()->pfResponce($user,true);   //using a  macro response 
    // }


    public function getImagePath($request){
        $path=null;
        if ($request->hasFile('image')) {
             $path = $request->image->store('images');
             $path = url(Storage::url($path));

        }
        return $path;
        
    }




    public function verfiyEmail(EmailVerificationRequest $request,$id){
        $user=User::find($id);
        $message ="user is verifed successfully...";
        $status=false;
        if(! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            DB::table('password_resets')->where('email', $user->email)->delete();
            $status=true;
        }else{
            $message="user is alraedy verified";
        }
        return response()->pfResponce($message,$status);
    }





    public function login(LoginRequest $request){
        $user= User::where('email',$request->input('email'))->first(); //$request->user;
        $data="user not found";
        $status=false;
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $user->remember_token=Str::random(40);
            $user->save();
            $user->tokens()->create(['token' => $user->remember_token]);
            $data=$user;
            $status=true;
        }
        return response()->pfResponce($data,$status);     
    }


    public function forgot(ForgotPasswordRequest $request){
        //$tokenLink=route('password.reset', [sha1($request->input('email'))]);
        $randomNumber = rand(100000, 999999);
        SendEmailJob::dispatch(['email'=>$request->email,'tokenlink'=>$randomNumber,'subject'=>"Reset Password Email"]);
        DB::table('password_resets')->insert(['email' => $request->input('email'),'token' => $randomNumber,'created_at' => Carbon::now()]);
        return response()->pfResponce("forgot token send to your email",true);
    }

    public function verfiyResetPassword(Request $request,$token){
        $ptokens= DB::table('password_resets')->where('token', $token)->where('email', $request->input('email'))->first();
            if((!is_null($ptokens))&& Carbon::parse($ptokens->created_at)->addMinutes(50)->gte(Carbon::now())){
                return response()->pfResponce($ptokens,true);

            }

            return response()->pfResponce("error in request",false);
    }


    
    public  function restPassword(ResetPasswordRequest $request) {
        $user= User::where('email',$request->input('email'))->first();
        $user->password=$request->input('password');
        $user->save();
        return response()->pfResponce("password successfully reset...",true); 
    }

    public function userList(?int $id = null){
        if($id){
            $users=User::find($id);
        }else{
            $users=User::all();
        }
        
        if($users){
            return response()->pfResponce($users,true); 
        }
        return response()->pfResponce('user not found',false); 
        
        
    }

    public function update(Request $request,$id){
        $user=User::find($id);
        if($user){
            if ($request->filled('first_name')) {
                $user->first_name = $request->input('first_name');
            }
    
            if ($request->filled('last_name')) {
                $user->last_name = $request->input('last_name');
            }
            if ($request->filled('bio')) {
                $user->bio = $request->input('bio');
            }
            if ($request->filled('gender')) {
                $user->gender = $request->input('gender');
            }
            if ($request->filled('address')) {
                $user->address = $request->input('address');
            }
            if ($request->filled('date_of_birth')) {
                $user->date_of_birth = $request->input('date_of_birth');
            }
            if ($request->filled('status')) {
                $user->status = $request->input('status');
            }
            if ($request->hasFile('image')){
                $photo=$this->getImagePath($request);
                $user->photo=$photo;
            }
            
            $user->save();
            return response()->pfResponce($user,true);  
        }
       
        return response()->pfResponce('user not found',false);  
        
    }
    

    public function destroy(Request $request,$id){
        $user=User::find($id);
        if($user){
            
            $user->delete();
            return response()->pfResponce('user deleted successfully',true);  
        }
       
        return response()->pfResponce('user not found',false);  
        
    }

     public function logout(Request $request){
        
            Token::where('token', $request->bearerToken())->delete();
            return response()->pfResponce('user logout successfully',true);  
      
        
    }

    


   



}
