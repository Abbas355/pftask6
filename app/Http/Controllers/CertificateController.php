<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function add(CertificateRequest $request){
        
        $certificatesData = $request->input('certificates'); // Assuming 'Certificates' is an array in the request
       $addedCertificates = [];

     foreach ($certificatesData as $certificateData) {
    $certificate = Certificate::create($certificateData);
    $addedCertificates[] = $certificate;
    }
 
return response()->pfResponce($addedCertificates, true);

    }
    public function update(Request $request,$id){
        $certificate=Certificate::find($id);
        
        if($certificate){
            if ($request->filled('title')) {
                $certificate->title = $request->input('title');
            }
    
            if ($request->filled('description')) {
                $certificate->description = $request->input('description');
            }
            if ($request->filled('certificate_img')) {
                $certificate->certificate_img = $request->input('certificate_img');
            }
            $certificate->save();
            return response()->pfResponce($certificate,true);  
        }
       
        return response()->pfResponce('Certificate not found',false);  
    }
    public function delete(Request $request,$id){
        $certificate=Certificate::find($id);
        if($certificate){
            $certificate->delete();
            return response()->pfResponce('Certificate deleted successfully',true);  
        }
       
        return response()->pfResponce('Certificate not found',false); 
    }
    public function list(?int $id = null){
        if($id){
            $certificate=Certificate::find($id);
        }else{
            $certificate=Certificate::all();
        }

        if($certificate){
            return response()->pfResponce($certificate,true); 
        }
        return response()->pfResponce('Certificate not found',false); 
        
        

    }
}
