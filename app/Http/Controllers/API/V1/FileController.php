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
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        if ($key != $request->key ) {
            return $this->respondWithError('parameters failed validation');
        }
        $file = $request->file;
        $filePath = "";
        $file_name = time().time().uniqid().'.'.$file->getClientOriginalExtension();
        $fileDir   = base_path() .'/public/assets/uploads/';
        if(in_array($file->getClientOriginalExtension(), ['jpeg' , 'jpg', 'gif', 'png', 'tif', 'tiff','webm','mkv','flv','flv','vob','ogg','ogg','ogv','gif','wmv','mp4','m4p','m4p','m4v','mpg','3gp','pdf']))
        {
          $upload_file = $file->move($fileDir,$file_name);
          $filePath  = '/public/assets/uploads/'.$file_name;
          return $this->respond(['path' => $filePath]);
        }
        else {
          return $this->respondWithError('extention is not valid');
        }
    }


    public function fileAsDataUpload( Request $request )
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

        if(strlen($file)>0)
        {
            list($extension, $file) = explode(';', $file);
            $extension = explode("/", $extension);
            $extension = $extension[1];
            list(, $file)      = explode(',', $file);
            $file = base64_decode($file);
            $filename = time().time().uniqid();
            if(in_array($extension, ['jpeg' , 'jpg', 'gif', 'png', 'tif', 'tiff','webm','mkv','flv','flv','vob','ogg','ogg','ogv','gif','wmv','mp4','m4p','m4p','m4v','mpg','3gp']))
            {
              $fileDir   = base_path() .'/public/assets/uploads/';
              file_put_contents($fileDir."$filename.$extension", $file);
              $filePath  = "/public/assets/uploads/$filename.$extension";
              return $this->respond(['path' => $filePath]);
            }
            else {
              return $this->respondWithError('extention is not valid');
            }
        }
        else {
          return $this->respondWithError('file data is empty');
        }
    }





}
