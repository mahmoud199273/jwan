<?php 
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Transformers\ProfileTransformer;

use App\User;
use  Validator;

class UserController extends BaseController  
{

	public function profile( Request $request )
    {
    	$user =  $this->getAuthenticatedUser();
    	 return $this->sendResponse($user->toArray(), 'profile read succesfully');
    }


}

 ?>