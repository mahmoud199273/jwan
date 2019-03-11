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



    public static $Headers = [
      "Content-Type" => "application/json"
    ];
    public static function attachHeaders($response){
      return $response->withHeaders(Self::$Headers);
    }

    public static function Success($operationStatus,$data=null){ 
      if(!in_array($operationStatus, ["success","created","noContent"])) die("error: not a recognizable success status");
      $status = "success";
      $response_array["status"] = $status;
      switch ($operationStatus) {
        case "created":
          $status_code = ENUMS::Created;
          if($data==null) $data = ["message"=>"Created Successfully"];
          break;
        case "noContent": //success but there are no content, EX: delete requests
          $status_code = ENUMS::NoContent;
          break;
        default: //success
          $status_code = ENUMS::Success;
          break;
      }
      $response_array["data"] = ($operationStatus!="noContent") ? $data : null;
      $response = response($response_array, $status_code);
      $response = Self::attachHeaders($response);
      return $response;
    }



    public static function Fail($operationStatus,$data=null){ 
      if(!in_array($operationStatus, ["failedToProceed","validationError","validationDublicationError","resourceNotFound","userNotAuthenticated"])) die("error: not a recognizable fail status");
      $status = "fail";
      $response_array["status"] = $status;
      switch ($operationStatus) {
        case "validationError": 
          $status_code = ENUMS::ValidationError;
          if($data==null) $data = ["message"=>"Validation Error"];
          break;
        case "validationDublicationError": 
          $status_code = ENUMS::ValidationDublicationError;
          if($data==null) $data = ["message"=>"Validation Dublication Error"];
          break;
        case "resourceNotFound": 
          $status_code = ENUMS::ResourceNotFound;
          if($data==null) $data = ["message"=>"Resource Not Found"];
          break;
        case "userNotAuthenticated": 
          $status_code = ENUMS::UserNotAuthenticated;
          if($data==null) $data = ["message"=>"User Not Authenticated"];
          break;
        default: //success
          $status_code = ENUMS::FailedToProceed;
          if($data==null) $data = ["message"=>"Failed To Proceed"];
          break;
      }
      $response_array["data"] = $data;
      $response = response($response_array, $status_code);
      $response = Self::attachHeaders($response);
      return $response;
    }



}