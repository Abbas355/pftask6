<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function add(ExperienceRequest $request){
        $experiences = $request->input('experiences'); // Assuming 'Experiences' is an array in the request
        $addedExperiences = [];
  
        foreach ($experiences as $experienceData) {
          $experience = Experience::create($experienceData);
          $addedExperiences[] = $experience;
        }
  
        return response()->pfResponce($addedExperiences, true); 
      }

      public function update(Request $request,$id){ 
        $experience=Experience::find($id); 
        if($experience){
          if ($request->filled('role')) {
              $experience->role = $request->input('role');
          }
          if ($request->filled('club_name')) {
              $experience->club_name = $request->input('club_name');
          }
          if ($request->filled('start_date')) {
              $experience->start_date = $request->input('start_date');
          }
          if ($request->filled('end_date')) {
              $experience->end_date = $request->input('end_date');
          }
          if ($request->filled('description')) {
              $experience->description = $request->input('description');
          }
          if ($request->filled('experience_letter_img')) {
              $experience->experience_letter_img = $request->input('experience_letter_img');
          }
          $experience->save();
          return response()->pfResponce($experience,true);  
        }
       
        return response()->pfResponce('Experience not found',false);  
      }
      public function delete(Request $request,$id){
          $experience=Experience::find($id);
          if($experience){
              $experience->delete();
              return response()->pfResponce('Experience deleted successfully',true);  
          }
         
          return response()->pfResponce('Experience not found',false); 
      }
      public function list(?int $id = null){
          if($id){
              $experience=Experience::find($id);
          }else{
              $experience=Experience::all();
          }
  
          if($experience){
              return response()->pfResponce($experience,true); 
          }
          return response()->pfResponce('Experience not found',false); 
          
          
  
      }
}
