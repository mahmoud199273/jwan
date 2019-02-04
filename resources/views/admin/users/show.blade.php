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
    <form class="m-form" action="{{ config('app.admin_url') }}/users/{{ $user->id }}" method="post" enctype="multipart/form-data">
       
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
                <label for="city_id" class="col-2 col-form-label">{{ __('admin.country') }}</label>
                 <div class="col-9">
                <select name="countries_id"  class="form-control m-input" disabled="">
                    @if($countries)
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ $user->countries_id == $country->id? "selected" : "" }}> {{ $country->name_ar }}</option>
                        @endforeach
                    @endif
                </select>
                    {!! $errors->first('countries_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            
            <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}" disabled="">
                    <label for="countries_id" class="col-2 col-form-label">{{ __('admin.Type') }}</label>
                     <div class="col-9">
                    <select name="type"  class="form-control m-input" disabled="">
                       <option value="0" {{ $user->type == 0? "selected" : "" }} > 
                           {{ __('admin.Government') }} </option>
                       <option value="1" {{ $user->type == 1? "selected" : "" }}>
                            {{ __('admin.Personal') }} </option>
                       <option value="2" {{ $user->type == 2? "selected" : "" }} >
                            {{ __('admin.Private sector') }} </option>
                    </select>
                        {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                <div class="col-3">
                    <img src="{{url('')}}{{ str_replace('public/', '', $user->image) }}" 
                        alt="{{ $user->name }}" width="150" height="150" max-width="150" max-height="150" class="form-control m-input">
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
    
                <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.facebook') }}</label>
                    <div class="col-9">
                        <input type="text" name="facebook" 
                                    class="form-control m-input" placeholder="{{ __('admin.facebook') }}" value="{{ $user->facebook }}" disabled="">
                        {!! $errors->first('facebook', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.twitter') }}</label>
                    <div class="col-9">
                        <input type="text" name="twitter" 
                                    class="form-control m-input" placeholder="{{ __('admin.twitter') }}" value="{{ $user->twitter }}" disabled="">
                        {!! $errors->first('twitter', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('instagram') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.instagram') }}</label>
                    <div class="col-9">
                        <input type="text" name="instgrame" 
                                    class="form-control m-input" value="{{ $user->instgrame }}" disabled="">
                        {!! $errors->first('instagram', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.snapchat') }}</label>
                    <div class="col-9">
                        <input type="text" name="snapchat" 
                                    class="form-control m-input" placeholder="{{ __('admin.snapchat') }}" value="{{ $user->snapchat }}" disabled="">
                        {!! $errors->first('snapchat', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('linkedin') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.linkedin') }}</label>
                    <div class="col-9">
                        <input type="text" name="linkedin" 
                                    class="form-control m-input" placeholder="{{ __('admin.linkedin') }}" value="{{ $user->linkedin }}" disabled="">
                        {!! $errors->first('linkedin', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>
    
                <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.youtube') }}</label>
                    <div class="col-9">
                        <input type="text" name="youtube" 
                                    class="form-control m-input" placeholder="{{ __('admin.youtube') }}" value="{{ $user->youtube }}" disabled="">
                        {!! $errors->first('youtube', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
                </div>

                {{-- <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label"> {{ __('admin.commission') }} </label>
                    <div class="col-9">
                        <input type="text" name="user_commission" class="form-control m-input" placeholder="{{ __('admin.commission') }}" value="{{ $user->user_commission }}" disabled>
                    </div>
                </div> --}}
    

        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/users')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection