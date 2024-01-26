<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function add(PlayerRequest $request){
        $Player=Player::create($request->only(['user_id','sport_id','jersey_number','position_id','height','weight']));
        return response()->pfResponce($Player,true); 
    }
    public function update(Request $request,$id){
        $Player=Player::find($id);
        
        if($Player){
            if ($request->filled('user_id')) {
                $Player->user_id = $request->input('user_id');
            }
            if ($request->filled('sport_id')) {
                $Player->sport_id = $request->input('sport_id');
            }
    
            if ($request->filled('jersey_number')) {
                $Player->jersey_number = $request->input('jersey_number');
            }
            if ($request->filled('position_id')) {
                $Player->position_id = $request->input('position_id');
            }
            if ($request->filled('height')) {
                $Player->height = $request->input('height');
            }
            if ($request->filled('weight')) {
                $Player->weight = $request->input('weight');
            }
            
            $Player->save();
            return response()->pfResponce($Player,true);  
        }
       
        return response()->pfResponce('player not found',false);  
    }
    public function delete(Request $request,$id){
        $Player=Player::find($id);
        if($Player){
            $Player->delete();
            return response()->pfResponce('Player deleted successfully',true);  
        }
       
        return response()->pfResponce('Player not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $Player=Player::with(['injuries', 'skills', 'achievements'])->find($id);
        }else{
            $Player=Player::with(['injuries', 'skills', 'achievements'])->get();
        }

        if($Player){
            return response()->pfResponce($Player,true); 
        }
        return response()->pfResponce('Player not found',false); 
        
        

    }
}
