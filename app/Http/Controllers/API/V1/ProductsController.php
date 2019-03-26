<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Transformers\ProductsTransformer;
use App\Transformers\TipsTransformer;
use App\Transformers\CouponsTransformer;
use App\Transformers\NotificationsTransformer;
use App\Transformers\ContactQuestionsTransformer;
use App\Transformers\FaqsTransformer;
use App\Transformers\OrdeTransformer;
use App\Tips;
use App\Coupons;
use App\Products;
use App\ProductOffers;
use App\Notification;
use App\Faqs;
use App\ContactQuestions;
use App\ContactAnswers;
use App\Orders;
use App\OrderItems;

class ProductsController extends Controller
{
    //

    protected $tipsTransformer;
    protected $productsTransformer;
    protected $couponsTransformer;
    protected $notificationsTransformer;
    protected $contactQuestionsTransformer;
    protected $faqsTransformer;
    protected $ordeTransformer;

    function __construct(Request $request, 
    ProductsTransformer $productsTransformer, 
    CouponsTransformer $couponsTransformer, 
    NotificationsTransformer $notificationsTransformer,
    ContactQuestionsTransformer $contactQuestionsTransformer,
    FaqsTransformer $faqsTransformer,
    OrdeTransformer $ordeTransformer,
    TipsTransformer $tipsTransformer
    ){
        App::setlocale($request->lang);
    	$this->productsTransformer   = $productsTransformer;
    	$this->tipsTransformer   = $tipsTransformer;
        $this->couponsTransformer   = $couponsTransformer;
        $this->notificationsTransformer   = $notificationsTransformer;
        $this->contactQuestionsTransformer   = $contactQuestionsTransformer;
        $this->faqsTransformer   = $faqsTransformer;
        $this->ordeTransformer   = $ordeTransformer;
    }


    public function index(Request $request)
    {
        $data = Products::where('offer',0)->orderby('id','desc')->get();
        $products = $this->productsTransformer->transformCollection($data);

        return $this->sendResponse($products, trans('lang.bank account read succesfully'),200);
    }
    public function Tips(Request $request)
    {
        $data = Tips::orderby('id','desc')->get();
        $items = $this->tipsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }

    public function Coupons(Request $request)
    {
        $data = Coupons::orderby('id','desc')->get();
        $items = $this->couponsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }


    public function Offers(Request $request)
    {
        $data = Products::where('offer',1)->orderby('id','desc')->get();
        $items = $this->productsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }
    
    
    public function Notifications(Request $request)
    {
        $data = Notification::orderby('id','desc')->get();
        $items = $this->notificationsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }

    public function Faqs(Request $request)
    {
        $data = Faqs::orderby('id','desc')->get();
        $items = $this->faqsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }

    public function Opinion(Request $request)
    {
        $data = ContactQuestions::orderby('id','desc')->get();
        $items = $this->contactQuestionsTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
    }
    
    public function OpinionAnswer(Request $request)
    {
        $validator = Validator::make( $request->all(), [

            //'qest_answer_ids'         => 'required',
            
            
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $items  = $request->qest_answer_ids;
        $quest_ids='';
        $answers='';
        foreach ($items  as $item) {
            
            $quest_ids.=$item['id'].',';
            $answers.=$item['answer'].',';
            
        }

        $contactAnswers = new ContactAnswers;


        $contactAnswers->quest_ids            = rtrim($quest_ids,',');

        $contactAnswers->answers            = rtrim($answers,',');

        $contactAnswers->notes            = $request->notes;


        $contactAnswers->save();

        foreach ($items  as $item) {
            DB::table('quest_answers')->insert([
                'quest_ids'         => $item['id'] ,
                'answers'  => $item['answer'], 
                'contact_id'  => $contactAnswers->id 
                                                ]);
           
        }
        

        return $this->respondWithSuccess(trans('api_msgs.created'));
    }


    public function SaveOrder(Request $request)
    {
        $validator = Validator::make( $request->all(), [

            'name'             => 'required',
            'email'          => 'required|email',
            'phone'           => 'required',
            'address'          => 'required',
            'lat'           => 'required',
            'lng'         => 'required',
            'order_date'              => 'required',
            'order_time'            => 'required',
            'payment_type'           => 'required',
            'price'       => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $discount=0;
        $price_after_discount=0;


        $order = new Orders;
        $order->name            = $request->name;
        $order->email            = $request->email;
        $order->phone            = $request->phone;
        $order->address            = $request->address;
        $order->notes            = $request->notes;
        $order->lat            = $request->lat;
        $order->lng            = $request->lng;
        $order->order_date            = $request->order_date;
        $order->order_time            = $request->order_time;
        $order->payment_type            = $request->payment_type;
        $order->price            = $request->price;
        $order->coupon            = $request->coupon;
        $order->delivery_fees            = 10;
        $order->discount            = $discount;
        $order->price_after_discount            = $price_after_discount;
        $order->save();


        $items  =$request->items_arr;

            foreach ($items  as $item) {

                $item_details = Products::find($item['id']);
                OrderItems::create([

                'order_id'       => $order->id,
                'product_id'              => $item['id'],
                'qnt'              => $item['qnt'],
                'price'              => $item_details->price,
                'total_price'              => $item_details->price * $item['qnt']
                ]);
            }


        return $this->respondWithSuccess(trans('api_msgs.created'));    


    }

    public function CurrentOrders(Request $request)
    {
        $validator = Validator::make( $request->all(), [

            'phone'           => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $data = Orders::where('phone',$request->phone)->where('status','<','4')->orderby('id','desc')->get();
        $items = $this->ordeTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
        
    }


    public function PastOrders(Request $request)
    {
        $validator = Validator::make( $request->all(), [

            'phone'           => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $data = Orders::where('phone',$request->phone)->where('status','=','4')->orderby('id','desc')->get();
        $items = $this->ordeTransformer->transformCollection($data);

        return $this->sendResponse($items, trans('lang.bank account read succesfully'),200);
        
    }
}
