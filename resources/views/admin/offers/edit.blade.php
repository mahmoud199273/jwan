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
                   {{ $offer->campaign->name_ar }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/offers')}}/{{ $offer->id }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            {{ method_field('PATCH') }}
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

            <div class="form-group m-form__group row {{ $errors->has('influncer_id') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.influencer_name') }}</label>
                <div class="col-9">
                    <select name="influncer_id"  class="form-control">
                        @if($influncers)
                            @foreach ($influncers as $influncer)
                                <option value="{{ $influncer->id }}" {{ ($influncer->id ==  $offer->influncer_id)? "selected" : "" }}> 
                                    {{ $influncer->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    {!! $errors->first('influncer_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('user_id') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.user_name') }}</label>
                <div class="col-9">
                        <select name="user_id"  class="form-control">
                                @if($users)
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ ($user->id ==  $offer->user_id)? "selected" : "" }}> 
                                            {{ $user->name }}</option>
                                    @endforeach
                                @endif
                        </select>
                    {!! $errors->first('user_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

           
            <div class="form-group m-form__group row {{ $errors->has('campaign_id') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.campaign') }}</label>
                <div class="col-9">
                        <select name="campaign_id"  class="form-control">
                                @if($campaigns)
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}" {{ ($campaign->id ==  $offer->campaign_id)? "selected" : "" }}> 
                                            {{ $campaign->title }}</option>
                                    @endforeach
                                @endif
                        </select>
                    {!! $errors->first('campaign_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           
            <div class="form-group m-form__group row {{ $errors->has('cost') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.cost') }}</label>
                <div class="col-9">
                    <input type="text" name="cost" class="form-control m-input" 
                            placeholder="{{ __('admin.cost') }}" value="{{ $offer->cost }}" >
                    {!! $errors->first('cost', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           
            <div class="form-group m-form__group row {{ $errors->has('description') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.description') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.description') }}" name="description" >{{ $offer->description }}</textarea>
                    {!! $errors->first('description', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            {{--  0,1,2,3,4,5,6,7  --}}
            <div class="form-group m-form__group row {{ $errors->has('status') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="status"  class="form-control m-input">
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
                    {!! $errors->first('status', '<span class="form-control-feedback">:message</span>') !!}
                </div>
        </div>

           
           
          

           


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                            <button type="submit" class="btn btn-brand">{{ __('admin.save') }}</button>
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