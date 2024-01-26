<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoachRequest;
use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function add(CoachRequest $request){
        $coach=Coach::create($request->only(['user_id','sport_id','specilization_id','height','weight']));
        return response()->pfResponce($coach,true); 
    }
    public function update(Request $request,$id){
        $coach=Coach::find($id);
        
        if($coach){
            if ($request->filled('sport_id')) {
                $coach->sport_id = $request->input('sport_id');
            }
            if ($request->filled('specilization_id')) {
                $coach->specilization_id = $request->input('specilization_id');
            }
            if ($request->filled('height')) {
                $coach->height = $request->input('height');
            }
            if ($request->filled('weight')) {
                $coach->weight = $request->input('weight');
            }
            
            $coach->save();
            return response()->pfResponce($coach,true);  
        }
       
        return response()->pfResponce('Coach not found',false);  
    }
    public function delete(Request $request,$id){
        $coach=Coach::find($id);
        if($coach){
            $coach->delete();
            return response()->pfResponce('Coach deleted successfully',true);  
        }
       
        return response()->pfResponce('Coach not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $coach=Coach::with(['experiences', 'licences', 'awards'])->find($id);
           // $coach=Coach::find($id);
        }else{
            $coach=Coach::with(['experiences', 'licences', 'awards'])->get();
           // $coach=Coach::all();
        }

        if($coach){
            return response()->pfResponce($coach,true); 
        }
        return response()->pfResponce('Coach not found',false); 
        
        

    }
}
