<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecilizationRequest;
use App\Models\Specilization;
use Illuminate\Http\Request;

class SpecilizationController extends Controller
{
    public function add(SpecilizationRequest $request){
        $specilization=Specilization::create($request->only(['sport_id','name','description']));
        return response()->pfResponce($specilization,true); 
    }
    public function update(Request $request,$id){
        $specilization=Specilization::find($id);
        
        if($specilization){
            if ($request->filled('name')) {
                $specilization->name = $request->input('name');
            }
    
            if ($request->filled('description')) {
                $specilization->description = $request->input('description');
            }
            if ($request->filled('sport_id')) {
                $specilization->sport_id = $request->input('sport_id');
            }
            $specilization->save();
            return response()->pfResponce($specilization,true);  
        }
       
        return response()->pfResponce('sport not found',false);  
    }
    public function delete(Request $request,$id){
        $specilization=Specilization::find($id);
        if($specilization){
            $specilization->delete();
            return response()->pfResponce('Specilization deleted successfully',true);  
        }
       
        return response()->pfResponce('Specilization not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $specilization=Specilization::find($id);
        }else{
            $specilization=Specilization::all();
        }

        if($specilization){
            return response()->pfResponce($specilization,true); 
        }
        return response()->pfResponce('Specilization not found',false); 
        
        

    }
}
