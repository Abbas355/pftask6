<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\SignupUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function add(SignupUserRequest $request){
        $photo=$this->setImage($request);
        $user=User::create($request->only(['name','password','email']));
        $user->photo=$photo;
        $user->save();
        $link=route('verfiy.user', [$user->id,sha1($user->email)]);
        Mail::send('email', ['link'=>$link,], function($message) use($request){
            $message->to($request->email); 
            $message->subject('Email Verification Mail');
        });
        DB::table('password_resets')->insert(['email' => $user->email,'token' => sha1($user->email),'created_at' => Carbon::now()]);
        return response()->json(["message" => "Users added succefully","data"=>$user], 201);
    }
    public function setImage($request){
        if ($request->hasFile('image')) {
             $path = $request->image->store('images');
        }
        return $path;
        
    }
    public function verfiyEmail(EmailVerificationRequest $request,$id){
        $user=User::find($id);
        $message ="user is verifed successfully...";
        if(! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            DB::table('password_resets')->where('email', $user->email)->delete();
        }else{
            $message="user is alraedy verified";
        }

        return $message;

    }

    public function login(Request $request){
        $user=User::where('email',$request->input('email'))->
        where('password',$request->input('password'))->first();
        if($user){
            return $user;
        }
        return "not exist";
    }
    public function forgotUser(Request $request){
        $user=User::where('email',$request->input('email'))->first();
        if($user){
            if($user->email_verified_at==null){
                return "verify your email";
            }
            $status = Password::sendResetLink(
                $request->only('email')
            );
         
            return $status === Password::RESET_LINK_SENT
                        ? ['status' => __($status)]
                        : ['email' => __($status)];
        }
    }

   public  function restPasswordUser(Request $request) {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(20));
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? ['status', __($status)]
                    : ['email' => [__($status)]];
    }
   

























//     public function addUser(Request $request){
//         $user=User::create($request->all());
//         //event(new Registered($user));
//         return response()->json(["message" => "Users added succefully","data"=>$user], 201);
//     }
//     public function loginUser(Request $request){
//         $user=User::where('email',$request->input('email'))
//         ->where('password',$request->input('password'))->first();
//         if($user){
//             if($user->email_verified_at==null){
//                 return "verify your email";
//             }
//             return "user exist";
//         }
//     }
//     public function forgotUser(Request $request){
//         $user=User::where('email',$request->input('email'))->first();
//         if($user){
//             if($user->email_verified_at==null){
//                 return "verify your email";
//             }
//             $status = Password::sendResetLink(
//                 $request->only('email')
//             );
         
//             return $status === Password::RESET_LINK_SENT
//                         ? ['status' => __($status)]
//                         : ['email' => __($status)];
//         }
//     }

//    public  function restPasswordUser(Request $request) {
       
     
//         $status = Password::reset(
//             $request->only('email', 'password', 'password_confirmation', 'token'),
//             function ($user, $password) {
//                 $user->forceFill([
//                     'password' => $password
//                 ])->setRememberToken(Str::random(20));
     
//                 $user->save();
     
//                 event(new PasswordReset($user));
//             }
//         );
     
//         return $status === Password::PASSWORD_RESET
//                     ? redirect()->route('login')->with('status', __($status))
//                     : ['email' => [__($status)]];
//     }
}
