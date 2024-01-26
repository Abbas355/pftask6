<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardRequest;
use App\Models\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function add(AwardRequest $request){
        $awards = $request->input('awards'); // Assuming 'Awards' is an array in the request
        $addedAwards = [];
  
        foreach ($awards as $awardData) {
          $award = Award::create($awardData);
          $addedAwards[] = $award;
        }
  
        return response()->pfResponce($addedAwards, true); 
      }

      public function update(Request $request,$id){ 
        $award=Award::find($id); 
        if($award){
            
          if ($request->filled('award_title')) {
              $award->award_title = $request->input('award_title');
          }
          if ($request->filled('award_img')) {
              $award->award_img = $request->input('award_img');
          }
         
          $award->save();
          return response()->pfResponce($award,true);  
        }
       
        return response()->pfResponce('Award not found',false);  
      }
      public function delete(Request $request,$id){
          $award=Award::find($id);
          if($award){
              $award->delete();
              return response()->pfResponce('Award deleted successfully',true);  
          }
         
          return response()->pfResponce('Award not found',false); 
      }
      public function list(?int $id = null){
          if($id){
              $award=Award::find($id);
          }else{
              $award=Award::all();
          }
  
          if($award){
              return response()->pfResponce($award,true); 
          }
          return response()->pfResponce('Award not found',false); 
          
          
  
      }
}
