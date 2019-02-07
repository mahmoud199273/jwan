@extends('admin.layouts.index_layout',['title' => __('admin.offer') ])

@section('content')

@if( session('status') )
<div class="m-alert m-alert--icon m-alert--air alert alert-success alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
        <i class="la la-warning"></i>
    </div>
    <div class="m-alert__text">
        <strong>{{ session('status') }}!</strong>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
</div>
@endif

<!--begin::Portlet-->
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-name">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                   {{ $offer->campaign->title }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{ config('app.admin_url') }}/cities/{{ $offer->id }}" method="post" enctype="multipart/form-data">
       
        <div class="m-portlet__body">

        @if($errors->any())
            <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text">
                    {{ __('admin.fix_errors') }}
                </div>
                <div class="m-alert__close">
                    <button type="button" class="close" data-close="alert" aria-label="Close">
                    </button>
                </div>
            </div>
        @endif

            <div class="form-group m-form__group row {{ $errors->has('name_ar') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.influencer_name') }}</label>
                <div class="col-9">
                    <input type="text" name="name_ar" class="form-control m-input" 
                            placeholder="{{ __('admin.influencer_name') }}" value="{{ $offer->influncer->name }}" disabled="">
                    {!! $errors->first('name_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.user_name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.user_name') }}" value="{{ $offer->user->name }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

           
            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.campaign') }}</label>
                <div class="col-9">
                    <input type="text" name="code" class="form-control m-input" 
                            placeholder="{{ __('admin.campaign') }}" value="{{ $offer->campaign->title }}" disabled="">
                    {!! $errors->first('code', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           
            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.cost') }}</label>
                <div class="col-9">
                    <input type="text" name="code" class="form-control m-input" 
                            placeholder="{{ __('admin.cost') }}" value="{{ $offer->cost }}" disabled="">
                    {!! $errors->first('code', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           
            <div class="form-group m-form__group row {{ $errors->has('desc') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.description') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.desc') }}" name="desc" disabled>{{ $offer->description }}</textarea>
                    {!! $errors->first('desc', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            {{--  0,1,2,3,4,5,6,7  --}}
            <div class="form-group m-form__group row {{ $errors->has('status') ? 'has-danger' : ''}}" disabled="">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="status"  class="form-control m-input" disabled>
                   <option value="0" {{ $offer->status == 0? "selected" : "" }} > 
                       {{  __('admin.new_offer') }} </option>
                   <option value="1" {{ $offer->status == 1? "selected" : "" }} > 
                        {{ __('admin.accepted') }}
                   </option>
                   <option value="2" {{ $offer->status == 2? "selected" : "" }} > 
                        {{ __('admin.refused') }}
                   </option>
                   <option value="3" {{ $offer->status == 3? "selected" : "" }} > 
                        {{ __('admin.pay') }}
                   </option>
                   <option value="4" {{ $offer->status == 4? "selected" : "" }} > 
                       {{ __('admin.in_progress') }}
                    </option>
                   <option value="5" {{ $offer->status == 5? "selected" : "" }} > 
                        {{ __('admin.proof_submitted') }}
                   </option>
                   <option value="6" {{ $offer->status == 6? "selected" : "" }} > 
                        {{ __('admin.proof_accepted') }}
                   </option>
                   <option value="7" {{ $offer->status == 7? "selected" : "" }} > 
                        {{ __('admin.done') }}
                   </option>
                   
                </select>
                    {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                </div>
        </div>

           
           
        <!--  chat modal of offers -->  


        <!-- <h5 class="text-center">معلومات العروض</h5> -->

            <div class="tab-pane active" id="pending" role="tabpanel">
                

                        <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                    <!-- <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label> -->
                    <div class="">
                       <!--  <img src="{{url('')}}{{ str_replace('public/', '', $offer->influncer->image) }}" 
                            alt="{{ $offer->influncer->name }}" width="150" height="150" max-width="150" max-height="150" class="form-control"> -->

                            <!-- <img src="{{url('')}}{{ str_replace('public/', '', $offer->influncer->image)  }}" id="image_file" width="100" height="100" >

                            <span>
                                                         {{$offer->influncer->name}}:&nbsp; {{$offer->description }}
                                                         </span> -->
                                                        
                    </div>

                     <div class="col-md-2">
<!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong{{$offer->id}}">
                         عرض المحادثة
                        </button>

                        

                       <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong{{$offer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">تفاصيل المحادثة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <ul class="list-group">
                                    @foreach($offer->chat as $chat)
                                    @if($chat)
                                    @php 
                                        $float="float:right";
                                        if(isset($chat->from_user->account_type) &&$chat->from_user->account_type == "1") $float="float:left";
                                    @endphp
                                    <li class="chat_container list-group-item pull-left" style="{{$float}}">
                                         {{--<img src="{{url('/')}}{{ str_replace('public/', '',isset( $chat->from_user->image) ? $chat->from_user->image : '')  }}" id="image_file" class="img-responsive img-circle" 
                                         alt=" {{ isset($chat->from_user->name)? $chat->from_user->name : '' }} " width="50px" height="50px">--}} &nbsp;
                                           <div id="image_file" class="chat_photo img-responsive img-circle" style="background-image: url('{{url('/')}}{{ str_replace('public/', '',isset( $chat->from_user->image) ? $chat->from_user->image : '')  }}');"></div>





                                         @php 
                                           $content = Crypt::decryptString($chat->content)
                                         @endphp

                                         @if(strpos($content,'public/assets/uploads'))
                                         <span>
                                         <img src="{{url('/')}}{{ str_replace('public/', '',$content)  }}" id="image_file" class="img-responsive" width="150px" height="150px">

                                         @else

                                         {{$content}}
                                     </span>

                                         @endif


                                     </li>
                                     @endif
                                     @endforeach



                                </ul> 
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        
                                                        
                    </div>


                     </div>

                    </hr>



            </div>
           



        <!-- end of chat modal -->






           


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/offers')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->


@endsection