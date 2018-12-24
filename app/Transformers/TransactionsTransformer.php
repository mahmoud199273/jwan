<?php

namespace App\Transformers;
use App\Attachment;
use App\Campaign;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\User;
use App\Setting;
use Carbon\Carbon;



class TransactionsTransformer extends Transformer
{
    protected $flag = false;
    protected $user_flag = true;

    function setColor($status,$type)
    {
        $this->color = "#F5BC1E"; // yellow min
        if ($status == 0) 
        {
            $this->color = "#F5BC1E"; // yellow min 
        } 
        elseif($type == 0 && $status == 1)
        {
            $this->color = "#21BDA8"; // green down
        }
        elseif ($type == 1 && $status == 1) 
        {
            $this->color = "#FF4C44";// red up
        }
        elseif ($type == 3 && $status == 1) 
        {
            $this->color = "#FF4C44";// red up
        }
        else
        {
            $this->color = "#21BDA8";  // green down
        }
        
        return $this->color;
    }
    //
    // function setUserFlag($user_flag)
    // {
    //     $this->user_flag = $user_flag; // set true to show influencers in campaigns list
    // }



	public function transform( $transaction  ) : array
    {
			$status_array = array(0 => 'فى انتظار الموافقه',
                      			1 => 'تم بنجاح',
                      			2 => 'تم الرفض',
                      			3 => 'تم الإنتهاء من التحويل',
                      			4 => 'تم الغاءالتحويل',
                      			5 => 'تم غلق التحويل');
      $direction_array = array(0 => 'In',
                      			1 => 'Out');
      $type_array = array(0 => 'user bank transfer',
                      			1 => 'approved offer (pending)',
                          2 => 'finished offer (in influncer)');
        $campaign = Campaign::find($campaign->id);
        $settings = Setting::first();
        $commission = (int)$settings->commission;

        $return_array =  [
        	'id'       			=> (int) $transaction->id,
            'user_id'           => (int) $transaction->user_id,
            'amount'            => $transaction->amount,
            'cost'              => round((($transaction->amount * 95) / 100), 2), //(int)(($transaction->amount * 95) / 100),
            'vat'               => round((($transaction->amount * 5) / 100), 2), //(int) ($transaction->amount * 5) / 100,
            'commission'        => round((($transaction->amount * $commission) / 100), 2),
            'campaign_id'       => (int) $transaction->campaign_id,
            'campaign_title'       => $transaction->title,
            'offer_id'       => (int) $transaction->offer_id,
            'status'       => (int) $transaction->status,
            'status_title'	=> $status_array[(int) $transaction->status],
            'direction'       => $transaction->direction,
            'direction_title'	=> $direction_array[(int) $transaction->direction],
            'type'       => (int) $transaction->type,
            'type_title'	=> $type_array[(int) $transaction->type],
            'image'       => $transaction->image,
            'transaction_bank_name'       => $transaction->transaction_bank_name,
            'transaction_account_name'       => $transaction->transaction_account_name,
            'transaction_account_number'       => $transaction->transaction_account_number,
            'transaction_account_IBAN'       => $transaction->transaction_account_IBAN,
            'transaction_number'       => $transaction->transaction_number,
            'transaction_date'       => Carbon::parse($transaction->transaction_date)->toDateTimeString(),
            'transaction_date_string'     => Carbon::createFromTimeStamp(strtotime($transaction->transaction_date))->diffForHumans(),
            'transaction_amount'       => $transaction->transaction_amount,
            'transaction_user_name'           => $transaction->user_name,
            'transaction_user_image'           => $transaction->user_image,
            'transaction_user_id'           => $transaction->transaction_user_id,
            'color'           => $this->setColor((int) $transaction->status,(int) $transaction->type),
            'created_at'       => Carbon::parse($transaction->created_at)->toDateTimeString(),
            'created_at_string'     => Carbon::createFromTimeStamp(strtotime($transaction->created_at))->diffForHumans(),
            'updated_at'          => Carbon::parse($transaction->updated_at)->toDateTimeString(),
            'updated_at_string'     => Carbon::createFromTimeStamp(strtotime($transaction->updated_at))->diffForHumans(),





            //'user'              => isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ,
            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,
            //'file'              => isset($campaign->attachments) ? $campaign->attachments : null,
            //'number_of_offers'  =>  Offer::where('campaign_id',$campaign->id)->count(),
            // 'status'   => (int) $transaction->status,
						// 'status_title'	=> $status_array[(int) $transaction->status],
            //
            // 'categories' => isset($transaction->categories) ? $transaction->categories : null,
            //
            // 'countries' => isset($transaction->countries) ? $transaction->countries : null,
            //
            // 'areas' => isset($transaction->areas) ? $transaction->areas : null,
            //
						// 'is_extened'	=> isset($transaction->is_extened) ? $transaction->is_extened : 0


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
