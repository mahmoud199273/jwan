@extends('admin.layouts.index_layout',['title' => __('admin.users') ])

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
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    {{ $user->name }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{ config('app.admin_url') }}/influencers/{{ $user->id }}" method="post" enctype="multipart/form-data">
       
              {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $user->id }}">
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

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ $user->name }}" disabled>
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.phone') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.phone') }}" name="phone" value="{{ $user->phone }}" disabled>
                    {!! $errors->first('phone', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.email') }}</label>
                <div class="col-9">
                    <input type="email" class="form-control m-input" 
                            placeholder="{{ __('admin.email') }}" name="email" value="{{ $user->email }}" disabled>
                    {!! $errors->first('email', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            

            <div class="form-group m-form__group row {{ $errors->has('countries_id') ? 'has-danger' : ''}}">
                    <label for="countries_id" class="col-2 col-form-label">{{ __('admin.country') }}</label>
                     <div class="col-9">
                    <select name="countries_id"  class="form-control m-input" disabled>
                        @if($countries)
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                {{ $user->countries_id == $country->id? "selected" : "" }}
                                > {{ $country->name_ar }}</option>
                            @endforeach
                        @endif
                    </select>
                        {!! $errors->first('countries_id', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('nationality_id') ? 'has-danger' : ''}}">
                    <label for="countries_id" class="col-2 col-form-label">{{ __('admin.natoinality') }}</label>
                     <div class="col-9">
                    <select name="nationality_id"  class="form-control m-input" disabled>
                        @if($nationalities)
                            @foreach ($nationalities as $row)
                                <option value="{{ $row->id }}"
                                {{ $user->nationality_id == $row->id? "selected" : "" }}    
                                > {{ $country->name_ar }}</option>
                            @endforeach
                        @endif
                    </select>
                        {!! $errors->first('nationality_id', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
            
            {{--  <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}" disabled="">
                    <label for="countries_id" class="col-2 col-form-label">{{ __('admin.Type') }}</label>
                     <div class="col-9">
                    <select name="type"  class="form-control m-input">
                       <option value="0" {{ $user->type == 0? "selected" : "" }} > 
                           {{ __('admin.Government') }} </option>
                       <option value="1" {{ $user->type == 1? "selected" : "" }}>
                            {{ __('admin.Personal') }} </option>
                       <option value="2" {{ $user->type == 2? "selected" : "" }} >
                            {{ __('admin.Private sector') }} </option>
                    </select>
                        {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>  --}}


            <div class="form-group m-form__group row {{ $errors->has('account_manger') ? 'has-danger' : ''}}" disabled="">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.account_manger') }}</label>
                 <div class="col-9">
                <select name="account_manger"  class="form-control m-input" disabled>
                   <option value="0" {{ $user->account_manger == 0? "selected" : "" }} > 
                       {{ __('admin.manager') }} </option>
                   <option value="1" {{ $user->account_manger == 1? "selected" : "" }}>
                        {{ __('admin.PersonalYou') }} </option>
                </select>
                    {!! $errors->first('account_manger', '<span class="form-control-feedback">:message</span>') !!}
                </div>
        </div>

            
            
            <div class="form-group m-form__group row {{ $errors->has('notes') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.notes') }}</label>
                    <div class="col-9">
                        <textarea class="form-control m-input" placeholder="{{ __('admin.notes') }}" name="notes" disabled="">{{ $user->notes }}</textarea>
                        {!! $errors->first('notes', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>
            


            <div class="form-group m-form__group row {{ $errors->has('is_active') ? 'has-danger' : ''}}">
                    <label for="is_active" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                     <div class="col-9">
                    <select name="is_active"  class="form-control m-input" disabled="">
                       <option value="1" {{ $user->is_active == 1? "selected" : "" }} > {{ __('admin.active') }} </option>
                       <option value="0" {{ $user->is_active == 0? "selected" : "" }} > {{ __('admin.in-active') }} </option>
                    </select>
                        {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
            
            <div class="form-group m-form__group row {{ $errors->has('gender') ? 'has-danger' : ''}}">
                    <label for="gender" class="col-2 col-form-label">{{ __('admin.gender') }}</label>
                     <div class="col-9">
                    <select name="gender"  class="form-control m-input" disabled="">
                       <option value="0"  {{ $user->gender == 1? "selected" : "" }} > {{ __('admin.male') }} </option>
                       <option value="1"  {{ $user->gender == 1? "selected" : "" }} > {{ __('admin.female') }} </option>
                       <option value="2"  {{ $user->gender == 2? "selected" : "" }} > {{ __('admin.general') }} </option>
                    </select>
                        {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>
    
            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                    <div class="col-3">
                        <img src="{{url('')}}{{ str_replace('public/', '', $user->image) }}" 
                            alt="{{ $user->name }}" width="150" height="150" max-width="150" max-height="150" class="form-control m-input">
                    </div>
                </div>
    
    
    

        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/influencers')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection