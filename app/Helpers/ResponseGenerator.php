<?php

namespace App\Helpers;
use Symfony\Component\HttpFoundation\Response;

abstract class ENUMS {
    const __default = 200;
    const Success = 200;
    const Created = 201;
    const NoContent = 204; //success but there are no content
    const FailedToProceed = 400;
    const ValidationError = 403;
    const ValidationDublicationError = 409;
    const ResourceNotFound = 404;
    const UserNotAuthenticated = 401; //The request requires user authentication
    const InternalServerError = 500;
}

class ResponseHelper extends ENUMS{
    //Please check: https://github.com/omniti-labs/jsend

    // status: (success or failure)
    // message: 
    // data: null or json array
    public static function res($status="success",$message=null,$data=null){
      if($status=="success"){ //All went well, and (usually) some data was returned.  
        return [
            "status" => "success",
            "data" => $data
        ];        
      }elseif($status=="fail"){ //There was a problem with the data submitted, or some pre-condition of the API call wasn't satisfied 
        return [
            "status" => "fail",
            "data" => $data
        ];     
      }elseif($status=="error"){ //An error occurred in processing the request, i.e. an exception was thrown  
        return [
            "status" => "error",
            "code" => $code,
            "message" => $message
        ];  
      }


                return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->offersTransformer->transform(Offer::find($request->id)),trans('lang.read succefully'),200);

    }


    public static function Success($operationStatus,$data=null){
      $status = "success";
      $response_array["status"] = $status;
      switch ($operationStatus) {
        case "created":
          $response_array["data"] = $data;
          $status_code = ENUMS::NoContent;
          break;
        case "noContent": //success but there are no content
          $response_array["data"] = $data;
          $status_code = ENUMS::NoContent;
          break;
        default: //success
          $response_array["data"] = $data;
          break;
      }
      $response = response($response_array, $status_code);
      $response = Self::attachHeaders($response);
      return $response;
    }


    public static $Headers = [];
    public static function attachHeaders($response){
      return $response->withHeaders(Self::$Headers);
    }



}