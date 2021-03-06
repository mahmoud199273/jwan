@extends('admin.layouts.index_layout',['title' => __('admin.campaign') ])

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
                    {{ __('admin.edit') }} | {{ $campaign->title }}
                </h3>
            </div>
        </div>
    </div>
 
    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/campaigns')}}/{{ $campaign->id }}" method="post" enctype="multipart/form-data">
       
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
       
        <div class="m-portlet__body">

   
                <div class="form-group m-form__group row {{ $errors->has('user_id') ? 'has-danger' : ''}}">
                        <label for="name" class="col-1 col-form-label">{{ __('admin.user_name') }}</label>
                        <div class="col-9">
                            <input type="hidden" name="user_id" value="{{ $campaign->user->id }}" />
                            <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.title') }}" value="{{ $campaign->user->name }}" disabled/>
                                {{--  <select name="user_id"  class="form-control">
                                        @if($users)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ ($user->id ==  $campaign->user_id)? "selected" : "" }}> 
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                </select>  --}}
                            {!! $errors->first('user_id', '<span class="form-control-feedback">:message</span>') !!}
                        </div>
                    </div>
        

            <div class="form-group m-form__group row {{ $errors->has('title') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.title') }}</label>
                <div class="col-9">
                    <input type="text" name="title" class="form-control m-input" 
                            placeholder="{{ __('admin.title') }}" value="{{ $campaign->title }}" >
                    {!! $errors->first('title', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('maximum_rate') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.maximum_rate') }}</label>
                <div class="col-9">
                    <input type="text" name="maximum_rate" class="form-control m-input" 
                            placeholder="{{ __('admin.maximum_rate') }}" value="{{ $campaign->maximum_rate }}" >
                    {!! $errors->first('maximum_rate', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.description') }}  </label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.description') }}" name="description" >{{ $campaign->description }}</textarea>
                    {!! $errors->first('description', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.scenario') }}  </label>
                <div class="col-9">
                    
                    <textarea class="form-control m-input" placeholder="{{ __('admin.scenario') }}" name="scenario" >{{ $campaign->scenario }}</textarea>
                    {!! $errors->first('scenario', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('campaign_countries') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.countries') }}  </label>
                <div class="col-9">
                   <select name="campaign_countries[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" >
                       @foreach ($countries as $item)
                       <option value="{{$item->id}}" {{ $campaign_countries->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                    {!! $errors->first('campaign_countries', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('campaign_categories') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.categories') }}  </label>
                <div class="col-9">
                   <select name="campaign_categories[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" >
                       @foreach ($categories as $item)
                       <option value="{{$item->id}}" {{ $campaign_categories->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                    {!! $errors->first('campaign_categories', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('campaign_areas') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label"> {{ __('admin.areas') }}  </label>
                <div class="col-9">
                   <select name="campaign_areas[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-select-all="true" data-width="100%" data-filter="true" >
                       @foreach ($areas as $item)
                       <option value="{{$item->id}}" {{ $campaign_areas->contains($item->id)? "selected" : "" }} > {{$item->name_ar}} 
                        </option>
                       @endforeach
                    </select>
                    {!! $errors->first('campaign_areas', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            
            <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                <label for="facebook" class="col-2 col-form-label">{{ __('admin.facebook') }}</label>
                 <div class="col-9">
                <select name="facebook"  class="form-control m-input" >
                   <option value="1" {{ $campaign->facebook == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->facebook == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('facebook', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                <label for="twitter" class="col-2 col-form-label">{{ __('admin.twitter') }}</label>
                 <div class="col-9">
                <select name="twitter"  class="form-control m-input" >
                   <option value="1" {{ $campaign->twitter == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->twitter == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('twitter', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                <label for="snapchat" class="col-2 col-form-label">{{ __('admin.snapchat') }}</label>
                 <div class="col-9">
                <select name="snapchat"  class="form-control m-input" >
                   <option value="1" {{ $campaign->snapchat == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->snapchat == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('snapchat', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                <label for="youtube" class="col-2 col-form-label">{{ __('admin.youtube') }}</label>
                 <div class="col-9">
                <select name="youtube"  class="form-control m-input" >
                   <option value="1" {{ $campaign->youtube == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->youtube == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('youtube', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('instgrame') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.instgrame') }}</label>
                 <div class="col-9">
                <select name="instgrame"  class="form-control m-input" >
                   <option value="1" {{ $campaign->instgrame == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->instgrame == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('instgrame', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           

            
            <div class="form-group m-form__group row {{ $errors->has('male') ? 'has-danger' : ''}}">
                <label for="male" class="col-2 col-form-label">{{ __('admin.male') }}</label>
                 <div class="col-9">
                <select name="male"  class="form-control m-input" >
                   <option value="1" {{ $campaign->male == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->male == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('male', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('female') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.female') }}</label>
                 <div class="col-9">
                <select name="female"  class="form-control m-input" >
                   <option value="1" {{ $campaign->female == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->female == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('female', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('general') ? 'has-danger' : ''}}">
                <label for="general" class="col-2 col-form-label">{{ __('admin.general') }}</label>
                 <div class="col-9">
                <select name="general"  class="form-control m-input" >
                   <option value="1" {{ $campaign->general == 1? "selected" : "" }} > {{ __('admin.yes') }} </option>
                   <option value="0" {{ $campaign->general == 0? "selected" : "" }} > {{ __('admin.no') }} </option>
                </select>
                    {!! $errors->first('general', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('status') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="status"  class="form-control m-input">
                   @if ($campaign->status == 0)
                   <option value="0" {{ $campaign->status == 0? "selected" : "" }} > {{  __('admin.new_campaign') }}</option>
                   <option value="1" {{ $campaign->status == 1? "selected" : "" }}> {{ __('admin.campaign_approved') }}
                    
                   
                 </option>
                   <option value="2" {{ $campaign->status == 2? "selected" : "" }} >  {{ __('admin.campaign_rejected') }}</option>
                   @elseif ($campaign->status > 0 && array_key_exists($campaign->status, $campaign_status))
                    <option value="{{ $campaign->status }}"  "selected"> 
                        {{ __('admin.'.$campaign_status[$campaign->status]) }}
                    </option>
                   @endif 


                    
                   
                   {{--  <option value="3" {{ $campaign->status == 3? "selected" : "" }} > {{ __('admin.campaign_in_progress') }}</option>
                   <option value="4" {{ $campaign->status == 4? "selected" : "" }} > {{ __('admin.campaign_Pending_proof') }}</option>
                   <option value="5" {{ $campaign->status == 5? "selected" : "" }} >  {{ __('admin.campaign_Pending_payment') }}</option>
                   <option value="6" {{ $campaign->status == 6? "selected" : "" }} > {{ __('admin.campaign_Confirmed') }}</option>
                   <option value="7" {{ $campaign->status == 7? "selected" : "" }} > {{ __('admin.campaign_finished') }}</option>
                   <option value="8" {{ $campaign->status == 8? "selected" : "" }} >  {{ __('admin.campaign_canceled') }}</option>
                   <option value="9" {{ $campaign->status == 9? "selected" : "" }} > {{ __('admin.campaign_closed') }}</option>  --}}
                   
                </select>
                    {!! $errors->first('status', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

           <!--  <div class="form-group m-form__group row {{ $errors->has('class') ? 'has-danger' : ''}}">
                <label for="class" class="col-2 col-form-label">{{ __('admin.class') }}</label>
                 <div class="col-9">
                <select name="class"  class="form-control m-input">
                   <option value="A">A </option>
                   <option value="B">B</option>
                   <option value="C">C </option>
                   <option value="D">D</option>
                </select>
                    {!! $errors->first('class', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div> -->

             <div class="form-group m-form__group row {{ $errors->has('class') ? 'has-danger' : ''}}">
                <label for="class" class="col-2 col-form-label">{{ __('admin.class') }}</label>
                 <div class="col-9">
                <select name="class"  class="form-control m-input" >
                   <option value="A" {{ $campaign->class == 'A'? "selected" : "" }} > A  </option>
                   <option value="B" {{ $campaign->class == 'B'? "selected" : "" }} > B  </option>
                   <option value="C" {{ $campaign->class == 'C'? "selected" : "" }} > C  </option>
                   <option value="D" {{ $campaign->class == 'D'? "selected" : "" }} > D  </option>
                </select>
                    {!! $errors->first('class', '<span class="form-control-feedback">:message</span>') !!}
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
                        <a type="reset" href="{{url('admin/campaigns')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->




@endsection