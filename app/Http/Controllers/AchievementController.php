<?php

namespace App\Http\Controllers;

use App\Http\Requests\AchievementRequest;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function add(AchievementRequest $request){
        
        $achievementsData = $request->input('achievements'); // Assuming 'achievements' is an array in the request
       $addedAchievements = [];

     foreach ($achievementsData as $achievementData) {
    $achievement = Achievement::create($achievementData);
    $addedAchievements[] = $achievement;
    }
 
return response()->pfResponce($addedAchievements, true);

    }
    public function update(Request $request,$id){
        $Achievement=Achievement::find($id);
        
        if($Achievement){
            if ($request->filled('title')) {
                $Achievement->title = $request->input('title');
            }
    
            if ($request->filled('description')) {
                $Achievement->description = $request->input('description');
            }
            if ($request->filled('date')) {
                $Achievement->date = $request->input('date');
            }
            if ($request->filled('img')) {
                $Achievement->img = $request->input('img');
            }
            $Achievement->save();
            return response()->pfResponce($Achievement,true);  
        }
       
        return response()->pfResponce('Achievement not found',false);  
    }
    public function delete(Request $request,$id){
        $Achievement=Achievement::find($id);
        if($Achievement){
            $Achievement->delete();
            return response()->pfResponce('Achievement deleted successfully',true);  
        }
       
        return response()->pfResponce('Achievement not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $Achievement=Achievement::find($id);
        }else{
            $Achievement=Achievement::all();
        }

        if($Achievement){
            return response()->pfResponce($Achievement,true); 
        }
        return response()->pfResponce('Achievement not found',false); 
        
        

    }
}
