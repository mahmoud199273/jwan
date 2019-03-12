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
    function setInfluncerFlag($flag)
    {
        $this->flag = $flag; // set true to show influencers in campaigns list
    }



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
        //$campaign = Campaign::find($campaign->id);
        $settings = Setting::first();
        
        $user = User::find($transaction->user_id);

        if($user->user_commission)
        {
            $commission = (int)$user->user_commission;
        }
        else
        {
            $commission = (int)$settings->commission;
        }
        
        $tax = (int)$settings->tax;

        $return_array =  [
        	'id'       			=> (int) $transaction->id,
            'user_id'           => (int) $transaction->user_id,
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

        if($transaction->fort_id )
        {
            if($transaction->payment_option == "VISA") 
                $return_array['image'] = "/public/assets/visa.png";
            else
               $return_array['image'] = "/public/assets/mastercard.png";     
        }

        if($this->flag) // influencer transactions
        {
            $commetion_value = $commission * $transaction->amount / 100;
            $return_array['amount'] = $transaction->amount - $commetion_value;
            $return_array['cost']   = $transaction->amount; 
            $return_array['vat'] = 0; 
            $return_array['commission'] = $commetion_value;
        }
        else 
        {

            if($transaction->offer_id !=0 && (int)$transaction->transaction_amount > (int)$transaction->amount)
            {

                $commission_vat_value = (float)$transaction->transaction_amount - (float)$transaction->amount;
                $commission_value = round((($transaction->amount * $commission) / 100), 2);
                $vat = round((($transaction->amount * $tax) / 100), 2);


                $return_array['amount']           = $transaction->transaction_amount;
                $return_array['cost']             = $transaction->amount; //(int)(($transaction->amount * 95) / 100),
                $return_array['vat']              = $vat; //(int) ($transaction->amount * 5) / 100,
                $return_array['commission']       = 0;
                //$return_array['commission']       = $commission_value;
            }
            else 
            {
                $return_array['amount']           = $transaction->amount;
                //$return_array['cost']             = round((($transaction->amount * 95) / 100), 2); //(int)(($transaction->amount * 95) / 100),
                $return_array['cost']             = $transaction->amount; //(int)(($transaction->amount * 95) / 100),
                $return_array['vat']              = 0; //(int) ($transaction->amount * $tax) / 100,
                //$return_array['vat']              = round((($transaction->amount * $tax) / 100), 2); //(int) ($transaction->amount * $tax) / 100,
                $return_array['commission']       = 0;
            }

            
        }
        

        return $return_array;
    }





}


?>