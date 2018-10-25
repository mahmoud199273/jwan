<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\ChatTransformer;
use App\Chat;
use App\Campaign;
use App\Offer;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;


class ChatController extends BaseController
{

    protected $chattransformer;


    function __construct(Request $request, ChatTransformer $chattransformer){
        App::setlocale($request->lang);
        $this->middleware('jwt.auth');
        $this->chattransformer   = $chattransformer;
    }


    public function index(Request $request)
    {
        	if ( $request->limit && $request->limit<30) {
        		$limit = $request->limit;
        	}
          else {
            $limit = 30;
          }
        	$this->setPagination($limit);

          $user =  $this->getAuthenticatedUser();

          $pagination = Chat::where([['from_user_id' ,$user->id],['campaign_id',$request->campaign_id],['to_user_id',$request->user_id]])
                            ->orWhere([['to_user_id' ,$user->id],['campaign_id',$request->campaign_id],['from_user_id',$request->user_id]])
        	                            ->orderBy('created_at','ASC')
        	                            ->paginate($this->getPagination());



    // select count(*) as aggregate from `chat` where (`from_user_id1` = 7 and `campaign_id` = 9 and `to_user_id` is null) or (`to_user_id` = 7 and `campaign_id` = 9 and `from_user_id` is null)

        // $pagination = Course::join('course_rates','course_rates.course_id','=','courses.id', 'LEFT OUTER')
    	  //   								   ->join('users','courses.instructor_id','=','users.id')
    	  //   	                               ->select('courses.*','users.name',DB::raw('SUM(course_rates.rate) as rate'))
    	  //   	                               ->groupBy('courses.id')
    	  //   	                               ->orderBy($orderBy,'DESC')
    	  //   	                               ->paginate($this->getPagination());



        	$chat =  $this->chattransformer->transformCollection(collect($pagination->items()));

        	return $this->respondWithPagination( $pagination, [ 'data' =>  $chat ]);
    }


public function store(Request $request)
{
    $user =  $this->getAuthenticatedUser();

    $validator = Validator::make($request->all() , [
          'campaign_id'    	=> 'required|exists:campaigns,id',
          //'offer_id'    		=> 'required|exists:offfers,id',
          'content'         => 'required|string',
      ]);

      if ($validator->fails()) {
          return $this->setStatusCode(422)->respondWithError('parameters faild validation');
      }
      else {
        $campaign = Campaign::find($request->campaign_id);

        if($campaign->user_id==$user->id)
        {
          //owner user
          $offer = Offer::where([['campaign_id' ,$campaign->id],['user_id',$user->id]])->get()->first();
          if(!$offer)
          {
            // error you can't start this
            return $this->setStatusCode(422)->respondWithError('you cant start offer');
          }
          dd($offer);
          $from_user_id = $user->id;
          $to_user_id = $offer->influcner_id;
        }
        else {
          //influncer
          $offer = Offer::where([['campaign_id' ,$campaign->id],['influncer_id',$user->id]])->get()->first();
          if(!$offer)
          {
            $offer = new Offer;
            $offer->influncer_id = $user->id;
            $offer->user_id = $campaign->user_id;
            $offer->campaign_id = $campaign->id;
            $offer->cost = "";
            $offer->description = $request->content;
            $offer->status = 1;
            $offer->save();
          }
          $from_user_id = $campaign->user_id;
          $to_user_id = $user->id;
        }

        $type = 1;
        if($request->type)
        {
          $type = (int) $request->type;
        }


        $chat =  new Chat;
        $chat->from_user_id 		= $from_user_id;
        $chat->to_user_id 	= $to_user_id;
        $chat->campaign_id = $campaign->id;
        $chat->offer_id = $offer->id;
        $chat->content = Crypt::encryptString($request->content);
        $chat->type = (int)$type;
        $chat->save();

        // push notifications

        return $this->respondWithSuccess(__('api_msgs.created'));
      }
}
/*





public function show( $id)
{
    $country = Country::find($id);
    if (   is_null($country)   ) {
        # code...
        return $this->sendError(  'post not found ! ');
    }
    return $this->sendResponse($country->toArray(), 'country read succesfully');

}



// update book
public function update(Request $request , Country $country)
{


}





// delete book
public function destroy(Country $country)
{



}*/




}
