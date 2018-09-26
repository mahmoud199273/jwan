<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{




    public function fileUpload( Request $request )
    {
        $key  = 'signify@123';

         $validator = Validator::make( $request->all() , [
            'file'      => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        if ($key != $request->key ) {
            return $this->respondWithError('parameters failed validation');
        }
        $file = $request->file;
        $filePath = "";      
        $file_name = time().time().uniqid().'.'.$file->getClientOriginalExtension();  
        $fileDir   = base_path() .'/public/assets/uploads/';
        $upload_file = $file->move($fileDir,$file_name); 
        $filePath  = '/public/assets/uploads/'.$file_name;

        return $this->respond(['path' => $filePath]);   
    }








}
