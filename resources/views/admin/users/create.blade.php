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
                   {{ __('admin.add') }} | {{ __('admin.users') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/users')}}" method="post" enctype="multipart/form-data">
       
            {{ csrf_field() }}
            <input type="hidden" name="account_type" value="0" />
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
                            placeholder="{{ __('admin.name') }}" value="{{ old('name') }}">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.phone') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.phone') }}" name="phone" value="{{ old('phone') }}">
                    {!! $errors->first('phone', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('countries_id') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.country') }}</label>
                 <div class="col-9">
                <select name="countries_id"  class="form-control m-input">
                    @if($countries)
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"> {{ $country->name_ar }}</option>
                        @endforeach
                    @endif
                </select>
                    {!! $errors->first('countries_id', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}">
                <label for="countries_id" class="col-2 col-form-label">{{ __('admin.Type') }}</label>
                 <div class="col-9">
                <select name="type"  class="form-control m-input">
                   <option value="0"> {{ __('admin.Government') }} </option>
                   <option value="1"> {{ __('admin.Personal') }} </option>
                   <option value="2"> {{ __('admin.Private sector') }} </option>
                </select>
                    {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.email') }}</label>
                <div class="col-9">
                    <input type="email" class="form-control m-input" 
                            placeholder="{{ __('admin.email') }}" name="email" value="{{ old('email') }}">
                    {!! $errors->first('email', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('password') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.password') }}</label>
                <div class="col-9">
                    <input type="password" name="password" 
                                class="form-control m-input" placeholder="{{ __('admin.password') }}" >
                    {!! $errors->first('password', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('notes') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.notes') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.notes') }}" name="notes">{{ old('notes') }}</textarea>
                    {!! $errors->first('notes', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            


            
            <div class="form-group m-form__group row {{ $errors->has('is_active') ? 'has-danger' : ''}}">
                <label for="is_active" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="is_active"  class="form-control m-input">
                   <option value="1"> {{ __('admin.active') }} </option>
                   <option value="0"> {{ __('admin.in-active') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.facebook') }}</label>
                <div class="col-9">
                    <input type="text" name="facebook" 
                                class="form-control m-input" placeholder="{{ __('admin.facebook') }}" >
                    {!! $errors->first('facebook', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.twitter') }}</label>
                <div class="col-9">
                    <input type="text" name="twitter" 
                                class="form-control m-input" placeholder="{{ __('admin.twitter') }}" >
                    {!! $errors->first('twitter', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('instagram') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.instagram') }}</label>
                <div class="col-9">
                    <input type="text" name="instagram" 
                                class="form-control m-input" placeholder="{{ __('admin.instagram') }}" >
                    {!! $errors->first('instagram', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.snapchat') }}</label>
                <div class="col-9">
                    <input type="text" name="snapchat" 
                                class="form-control m-input" placeholder="{{ __('admin.snapchat') }}" >
                    {!! $errors->first('snapchat', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('linkedin') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.linkedin') }}</label>
                <div class="col-9">
                    <input type="text" name="linkedin" 
                                class="form-control m-input" placeholder="{{ __('admin.linkedin') }}" >
                    {!! $errors->first('linkedin', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.youtube') }}</label>
                <div class="col-9">
                    <input type="text" name="youtube" 
                                class="form-control m-input" placeholder="{{ __('admin.youtube') }}" >
                    {!! $errors->first('youtube', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            {{-- <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-2 col-form-label"> {{ __('admin.commission') }} </label>
                <div class="col-9">
                    <input type="text" name="user_commission" 
                                class="form-control m-input" placeholder="{{ __('admin.commission') }}" >
                    <span style="font-size:16px;color:red"> ملحوظة : اذا تركت القيمة فارغة سيتم التعامل بمبلغ العمولة من الاعدادات </span>
                </div>
            </div> --}}




            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                    <div class="col-9">
                        <input type="hidden" name="image" id="file" class="form-control m-input" placeholder="{{ __('admin.image') }}">
                        {{--   upload image div   --}}
                        <div class="container">
                                <div class="row" style="padding-top:10px;">
                                  <div class="col-xs-2">
                                    <button id="uploadBtn" class="btn btn-large btn-primary"> اختر ملف </button>
                                  </div>
                                  <div class="col-xs-10">
                                <div id="progressOuter" class="progress progress-striped active" style="display:none;">
                                  <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                  </div>
                                </div>
                                  </div>
                                </div>
                                <div class="row" style="padding-top:10px;">
                                  <div class="col-xs-10">
                                    <div id="msgBox">
                                    </div>
                                  </div>
                                </div>
                                <img src="" id="image_file" width="100" height="100" style="display:none;">
                            </div>
  
                            {{--   upload image div   --}}
                        {!! $errors->first('image', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>
{{--              
            <div class="form-group m-form__group row {{ $errors->has('gender') ? 'has-danger' : ''}}">
                <label for="gender" class="col-2 col-form-label">{{ __('admin.status') }}</label>
                 <div class="col-9">
                <select name="gender"  class="form-control m-input">
                   <option value="0"> {{ __('admin.male') }} </option>
                   <option value="1"> {{ __('admin.female') }} </option>
                </select>
                    {!! $errors->first('is_active', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>  --}}




        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <button type="submit" class="btn btn-brand">{{ __('admin.save') }}</button>
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