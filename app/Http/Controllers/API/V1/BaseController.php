<?php
 
namespace App\Http\Controllers\API\V1;
use App\Traits\Restable;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;



class BaseController extends Controller  
{

    use ValidatesRequests, Restable;

    public function sendResponse($result , $message){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response , 200);
    }

    public function sendError($error , $errorMessages = [] , $code = 404){
        $response = [
            'success' => false ,
            'message' => $error
        ];
        if (!empty($errorMessages)) {
            # code...
            $response['date'] = $errorMessages;
        }
        return response()->json($response , $code);
        
    }


    public function uploadFile( $file , $path )
    {
        $filePath = "";      
        $file_name = time().time().uniqid().'.'.$file->getClientOriginalExtension();  
        $fileDir   = base_path() .'/public/assets/'.$path;
        $upload_file = $file->move($fileDir,$file_name); 
        $filePath  = '/public/assets/'.$path.$file_name;

        return $filePath;   
    }
  
}
