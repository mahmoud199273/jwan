<?php

namespace App\Transformers;
use App\Attachment;
use App\Campaign;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\User;
use Carbon\Carbon;



class TransactionsTransformer extends Transformer
{
    protected $flag = false;
    protected $user_flag = true;

    // function setFlag($flag)
    // {
    //     $this->flag = $flag; // set true to show influencers in campaigns list
    // }
    //
    // function setUserFlag($user_flag)
    // {
    //     $this->user_flag = $user_flag; // set true to show influencers in campaigns list
    // }



	public function transform( $tranaction  ) : array
    {
			$status_array = array(0 => 'pending',
                      			1 => 'approved',
                      			2 => 'rejected',
                      			3 => 'finished',
                      			4 => 'canceled',
                      			5 => 'closed');
      $direction_array = array(0 => 'In',
                      			1 => 'Out');
      $type_array = array(0 => 'user bank transfer',
                      			1 => 'Out');
        // $campaign = Campaign::find($campaign->id);
        $return_array =  [
        	  'id'       			=> (int) $tranaction->id,
            'user_id'           => (int) $tranaction->user_id,
            'amount'       => $tranaction->amount,
            'campaign_id'       => (int) $tranaction->campaign_id,
            'offer_id'       => (int) $tranaction->offer_id,
            'status'       => (int) $tranaction->status,
            'status_title'	=> $status_array[(int) $tranaction->status],
            'direction'       => $tranaction->direction,
            'direction_title'	=> $direction_array[(int) $tranaction->direction],
            'type'       => (int) $tranaction->type,
            'type_title'	=> $type_array[(int) $tranaction->type],
            'image'       => $tranaction->image,
            'transaction_bank_name'       => $tranaction->transaction_bank_name,
            'transaction_account_name'       => $tranaction->transaction_account_name,
            'transaction_account_number'       => $tranaction->transaction_account_number,
            'transaction_account_IBAN'       => $tranaction->transaction_account_IBAN,
            'transaction_number'       => $tranaction->transaction_number,
            'transaction_date'       => Carbon::parse($tranaction->transaction_date)->toDateTimeString(),
            'transaction_amount'       => $tranaction->transaction_amount,
            'created_at'       => Carbon::parse($tranaction->created_at)->toDateTimeString(),
            'updated_at'          => Carbon::parse($tranaction->updated_at)->toDateTimeString(),





            //'user'              => isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ,
            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,
            //'file'              => isset($campaign->attachments) ? $campaign->attachments : null,
            //'number_of_offers'  =>  Offer::where('campaign_id',$campaign->id)->count(),
            // 'status'   => (int) $tranaction->status,
						// 'status_title'	=> $status_array[(int) $tranaction->status],
            //
            // 'categories' => isset($tranaction->categories) ? $tranaction->categories : null,
            //
            // 'countries' => isset($tranaction->countries) ? $tranaction->countries : null,
            //
            // 'areas' => isset($tranaction->areas) ? $tranaction->areas : null,
            //
						// 'is_extened'	=> isset($tranaction->is_extened) ? $tranaction->is_extened : 0


        ];

        // if($this->user_flag)
        // {
        //     $return_array['user'] = isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ;
        // }
        // if($this->flag)
        // {
        //     $return_array['influencers']  = User::select('users.id','users.name','users.image')->join('offers', 'offers.influncer_id', '=', 'users.id')->where('offers.campaign_id',$campaign->id)->get();
        // }

        return $return_array;
    }





}


?>
