<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSports;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function add(AddSports $request){
        $sport=Sport::create($request->only(['sport_name','description','rules']));
        return response()->pfResponce($sport,true); 
    }
    public function update(Request $request,$id){
        $sport=Sport::find($id);
        
        if($sport){
            if ($request->filled('sport_name')) {
                $sport->sport_name = $request->input('sport_name');
            }
    
            if ($request->filled('description')) {
                $sport->description = $request->input('description');
            }
            if ($request->filled('rules')) {
                $sport->rules = $request->input('rules');
            }
            $sport->save();
            return response()->pfResponce($sport,true);  
        }
       
        return response()->pfResponce('sport not found',false);  
    }
    public function delete(Request $request,$id){
        $sport=Sport::find($id);
        if($sport){
            $sport->delete();
            return response()->pfResponce('sport deleted successfully',true);  
        }
       
        return response()->pfResponce('sports not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $sports=Sport::find($id);
        }else{
            $sports=Sport::all();
        }

        if($sports){
            return response()->pfResponce($sports,true); 
        }
        return response()->pfResponce('sports not found',false); 
        
        

    }
}
