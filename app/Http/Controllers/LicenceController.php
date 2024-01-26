<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicenceRequest;
use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    public function add(LicenceRequest $request){
        $licences = $request->input('licences'); // Assuming 'Licences' is an array in the request
        $addedLicences = [];
  
        foreach ($licences as $licenceData) {
          $licence = Licence::create($licenceData);
          $addedLicences[] = $licence;
        }
  
        return response()->pfResponce($addedLicences, true); 
      }

      public function update(Request $request,$id){ 
        $licence=Licence::find($id); 
        if($licence){
          if ($request->filled('issuing_authority')) {
              $licence->issuing_authority = $request->input('issuing_authority');
          }
          if ($request->filled('licence_name')) {
              $licence->licence_name = $request->input('licence_name');
          }
          if ($request->filled('issue_date')) {
              $licence->issue_date = $request->input('issue_date');
          }
          if ($request->filled('expire_date')) {
              $licence->expire_date = $request->input('expire_date');
          }
          if ($request->filled('licence_img')) {
              $licence->licence_img = $request->input('licence_img');
          }
          $licence->save();
          return response()->pfResponce($licence,true);  
        }
       
        return response()->pfResponce('Licence not found',false);  
      }
      public function delete(Request $request,$id){
          $licence=Licence::find($id);
          if($licence){
              $licence->delete();
              return response()->pfResponce('Licence deleted successfully',true);  
          }
         
          return response()->pfResponce('Licence not found',false); 
      }
      public function list(?int $id = null){
          if($id){
              $licence=Licence::find($id);
          }else{
              $licence=Licence::all();
          }
  
          if($licence){
              return response()->pfResponce($licence,true); 
          }
          return response()->pfResponce('Licence not found',false); 
          
          
  
      }
}
