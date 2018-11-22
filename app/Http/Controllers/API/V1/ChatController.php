<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\ChatTransformer;
use App\Chat;
use App\Campaign;
use App\Offer;
use Hash;
use App\Notification;
use Carbon\Carbon;
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
        	                            ->orderBy('id','DESC')
        	                            ->paginate($this->getPagination());

        	$chat =  $this->chattransformer->transformCollection(collect($pagination->items()));

        	return $this->respondWithPagination( $pagination, [ 'data' =>  $chat ]);
    }


public function store(Request $request)
{
    $user =  $this->getAuthenticatedUser();

    $validator = Validator::make($request->all() , [
          'campaign_id'    	=> 'required|exists:campaigns,id',
          //'offer_id'    		=> 'required|exists:offfers,id',
          //'content'         => 'required|string',
      ]);

      if ($validator->fails()) {
          return $this->setStatusCode(422)->respondWithError('parameters faild validation');
      }
      else {
        $campaign = Campaign::find($request->campaign_id);

        if($campaign->user_id==$user->id)
        {
          // user_id
          //owner user
          if($request->user_id)
          {
            $offer = Offer::where([['campaign_id' ,$campaign->id],['user_id',$user->id],['influncer_id',$request->user_id],['status','!=','2']])->get()->first();
          }
          else 
          {
            $offer = Offer::where([['campaign_id' ,$campaign->id],['user_id',$user->id],['status','!=','2']])->get()->first();
          }
          
          if(!$offer)
          {
            // error you can't start this
            return $this->setStatusCode(422)->respondWithError('you cant start offer');
          }
          $from_user_id = $user->id;
          $to_user_id = $offer->influncer_id;
          $who = 1;
          $chat_influncer_id = $offer->influncer_id;

        }
        else {
          //influncer
          $offer = Offer::where([['campaign_id' ,$campaign->id],['influncer_id',$user->id],['status','!=','2']])->get()->first();
          if(!$offer)
          {
            $offer = new Offer;
            $offer->influncer_id = $user->id;
            $offer->user_id = $campaign->user_id;
            $offer->campaign_id = $campaign->id;
            $offer->created_at   = Carbon::now()->addHours(3);
            $offer->cost = "";
            if($request->content){
              $offer->description = $request->content;
            }
            else 
            {
              $offer->description = " تم اضافة عرض جديد ";
            } 
            $offer->status = 1;
            $offer->save();
          }
          $from_user_id = $user->id;
          $to_user_id = $campaign->user_id;
          $who = 0;
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
        $chat->created_at   = Carbon::now()->addHours(3);
        $chat->updated_at   = Carbon::now()->addHours(3);
        $chat->type = (int)$type;
        if($request->content){
          $chat->content = Crypt::encryptString($request->content);
          $chat->save();
        }  
        

        // push notifications


        $player_ids = $this->getUserPlayerIds($to_user_id);
        Notification::create(['user_id' => $to_user_id,
                                  'from_user_id' => $user->id,  
                                  'message' => 'A new message was added',
                                  'message_ar' => 'لديك رساله جديده',
                                  'campaign_id' =>  $offer->campaign_id,
                                  'offer_id'    => $offer->id,
                                  'type'          =>  12,
                                  'type_title'  => 'new chat']);


        sendNotification($who,
                              'A new message was added',
                              'لديك رساله جديده',
                              $player_ids,"chat",
                              ['campaign_id' =>  (int)$offer->campaign_id,
                              'offer_id'    => (int)$offer->id,
                              'type'          =>  12,
                              'type_title'  => 'new chat',
                              'chat_content'         => $request->content,
                              'chat_type'       => $chat->type]);

        //return $this->respondWithSuccess(__('api_msgs.created'));
        return $this->sendResponse(['offer' => $offer->id ],trans('api_msgs.created'),200);
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
