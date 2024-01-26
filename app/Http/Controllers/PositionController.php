<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function add(PositionRequest $request){
        $position=Position::create($request->only(['name','description','sport_id']));
        return response()->pfResponce($position,true); 
    }
    public function update(Request $request,$id){
        $position=Position::find($id);
        
        if($position){
            if ($request->filled('name')) {
                $position->name = $request->input('name');
            }
    
            if ($request->filled('description')) {
                $position->description = $request->input('description');
            }
            if ($request->filled('sport_id')) {
                $position->sport_id = $request->input('sport_id');
            }
            $position->save();
            return response()->pfResponce($position,true);  
        }
       
        return response()->pfResponce('sport not found',false);  
    }
    public function delete(Request $request,$id){
        $position=Position::find($id);
        if($position){
            $position->delete();
            return response()->pfResponce('position deleted successfully',true);  
        }
       
        return response()->pfResponce('position not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $position=Position::find($id);
        }else{
            $position=Position::all();
        }

        if($position){
            return response()->pfResponce($position,true); 
        }
        return response()->pfResponce('position not found',false); 
        
        

    }
}
