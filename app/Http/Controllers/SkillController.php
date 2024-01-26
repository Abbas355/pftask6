<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function add(SkillRequest $request){
      $skills = $request->input('skills'); // Assuming 'skills' is an array in the request
    $addedSkills = [];

    foreach ($skills as $skillData) {
        $skill = Skill::create($skillData);
        $addedSkills[] = $skill;
    }

    return response()->pfResponce($addedSkills, true); 
    }
    public function update(Request $request,$id){
        $Skill=Skill::find($id);
        
        if($Skill){
            if ($request->filled('skill_name')) {
                $Skill->skill_name = $request->input('skill_name');
            }
            if ($request->filled('description')) {
                $Skill->description = $request->input('description');
            }
            if ($request->filled('skill_level')) {
                $Skill->skill_level = $request->input('skill_level');
            }
            $Skill->save();
            return response()->pfResponce($Skill,true);  
        }
       
        return response()->pfResponce('Skill not found',false);  
    }
    public function delete(Request $request,$id){
        $Skill=Skill::find($id);
        if($Skill){
            $Skill->delete();
            return response()->pfResponce('Skill deleted successfully',true);  
        }
       
        return response()->pfResponce('Skill not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $Skill=Skill::find($id);
        }else{
            $Skill=Skill::all();
        }

        if($Skill){
            return response()->pfResponce($Skill,true); 
        }
        return response()->pfResponce('Skill not found',false); 
        
        

    }
}
