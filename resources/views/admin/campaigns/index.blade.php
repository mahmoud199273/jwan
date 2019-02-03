@extends('admin.layouts.index_layout' , ['title' => __('admin.campaigns') ,'route' => 'campaigns'])

@section('content')

<div class="row">
    <form class="m-form" action="{{url('admin/campaign/search')}}" method="get" id="search_form">
        <div class="form-group m-form__group row ">
            <label for="q" class="col-1 col-form-label"></label>
            <div class="col-6">
                <input type="text" name="q" class="form-control m-input" 
                placeholder="{{ __('admin.search_word') }}">
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" id="confirm_search">
                    <span>
                        <i class="la la-search"></i>
                        <span>{{ __('admin.search') }}</span>
                    </span>
                </a>
            </div>
        </div>
    </form>
</div>
<br>
 
@if(isset($query))
<div class="row" style="padding-right: 35px;">
    <span>{{ __('admin.searched_for') }}</span>
    <span><b>"{{ $query}}"</b></span>
</div>
@endif

<br>


<div class="row">
    <div class="col-lg-12"> 

        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">

                    <!-- here can place a progress bar-->
                </div>
                <div class="m-portlet__head-wrapper">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="la la-envelope"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{ __('admin.campaigns') }}  
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">


                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><b>{{ __('admin.campaign_id') }}</b></th>
                                    <th><b>{{ __('admin.title') }}</b></th>
                                    <th><b>{{ __('admin.name') }}</b></th>
                                    <th><b>{{ __('admin.campaign_date') }}</b></th>
                                    <th><b>{{ __('admin.status') }}</b></th>
                                    <th><b>{{ __('admin.approved')}}</b></th>
                                    <th><b>{{ __('admin.offers_num')}}</b></th>
                                    <th><b>{{ __('admin.chat_num')}}</b></th>
                                    <th><b>{{ __('admin.control') }}</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($campaigns)
                                @foreach ($campaigns as $campaign)
                                <tr>
                                    <th scope="row">{{ $campaign->id }}</th>
                                    <th scope="row">{{ $campaign->title }}</th>
                                    <th scope="row">{{ $campaign->user->name }}</th>
                                    <th scope="row">{{ $campaign->created_at }}</th>
                                    <th scope="row">
                                        @if ($campaign->status == 0)
                                            {{  __('admin.new_campaign') }}

                                        @elseif ($campaign->status == 1)
                                            {{ __('admin.campaign_approved') }}

                                        @elseif ($campaign->status == 2)
                                            {{ __('admin.campaign_rejected') }}   

                                        @elseif ($campaign->status == 3)
                                            {{ __('admin.campaign_finished') }}

                                        @elseif ($campaign->status == 4)
                                            {{ __('admin.campaign_canceled') }}

                                        @elseif ($campaign->status == 5)
                                            {{ __('admin.campaign_closed') }}

                                        @else
                                            {{ __('admin.done') }}
                                        @endif
                                    </th>


                                     <td class="text-center">{!! ($campaign->status)? "<i class='fa fa-check m--font-success'></i>" : 
                                    "<i class='fa fa-times m--font-danger'></i>" !!}</td>

                                     <th scope="row">{{$campaign->offers->count()}}</th>

                                     <th scope="row">
                                     {{$campaign->chats->groupby('chats.offer_id')->count()}}
                                     
                                     </th>
                                    
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a type="button" 
                                            href="{{url('admin/campaigns')}}/{{ $campaign->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-eye m--font-info"></i>
                                        </a>
                                        
                                        <a type="button" 
                                            href="{{url('admin/campaigns')}}/{{ $campaign->id }}/edit" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            <i class="fa fa-edit m--font-info"></i>
                                        </a>
                                         <a type="button" 
                                            href="{{url('admin/offers')}}/{{ $campaign->id }}/campaign" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary">
                                            {{ __('admin.offers') }}
                                        </a>
                                         @if($campaign->status==0)
                                            <a type="button" href="javascript:;" data-status="1" data-id = "{{ $campaign->id }}"
                                                class="m-btn m-btn m-btn--square btn btn-secondary _campaignApprove">
                                                <i class="fa fa-check m--font-success"></i>
                                            </a>
                                             

                                           
                                            @endif

                                        <a type="button"  data-id = "{{ $campaign->id }}" 
                                            class="m-btn m-btn m-btn--square btn btn-secondary _remove">
                                            <i class="flaticon-delete-1 m--font-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            <!--end::Section-->

        </div>


    </div>
    <!--end::Portlet-->
</div>
</div>

<div class="container">
    <div class="text-center">
       @if($campaigns)
       {{ $campaigns->links() }}
       @endif
   </div>
</div>

<br>

@if(isset($query ) or isset($message))
<div>
    <a href="{{url('admin/campaigns')}}" class="btn btn-danger m-btn m-btn--icon m-btn--wide">
        <span>
            <i class="la la-warning"></i>
            <span>{{ __('admin.cancel_search') }}</span>
        </span>
    </a>
</div>
@endif







@endsection