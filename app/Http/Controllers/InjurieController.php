<?php

namespace App\Http\Controllers;

use App\Http\Requests\InjurieRequest;
use App\Models\Injury;
use Illuminate\Http\Request;

class InjurieController extends Controller
{
    public function add(InjurieRequest $request){
        $injuriesData = $request->input('injuries'); // Assuming 'injuries' is an array in the request
        $addedInjuries = [];
        
        foreach ($injuriesData as $injuryData) {
            $injury = Injury::create($injuryData);
            $addedInjuries[] = $injury;
        }
        
        return response()->pfResponce($addedInjuries, true);
    }
    public function update(Request $request,$id){
        $Injury=Injury::find($id);
        
        if($Injury){
            if ($request->filled('injury')) {
                $Injury->injury = $request->input('injury');
            }
            if ($request->filled('date')) {
                $Injury->date = $request->input('date');
            }
            if ($request->filled('expected_recovery_time')) {
                $Injury->expected_recovery_time = $request->input('expected_recovery_time');
            }
            $Injury->save();
            return response()->pfResponce($Injury,true);  
        }
       
        return response()->pfResponce('Injury not found',false);  
    }
    public function delete(Request $request,$id){
        $Injury=Injury::find($id);
        if($Injury){
            $Injury->delete();
            return response()->pfResponce('Injury deleted successfully',true);  
        }
       
        return response()->pfResponce('Injury not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $Injury=Injury::find($id);
        }else{
            $Injury=Injury::all();
        }

        if($Injury){
            return response()->pfResponce($Injury,true); 
        }
        return response()->pfResponce('Injury not found',false); 
        
        

    }
}
