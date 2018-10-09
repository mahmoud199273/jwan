@extends('admin.layouts.index_layout',['title' => __('admin.countries') ])

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
                   {{ __('admin.add') }} | {{ __('admin.country') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/country')}}" method="post" enctype="multipart/form-data">
       
            {{ csrf_field() }}
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
                <label for="name" class="col-1 col-form-label">{{ __('admin.name_en') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name_en') }}" value="{{ old('name') }}">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name_ar') ? 'has-danger' : ''}}">
                    <label for="name" class="col-1 col-form-label">{{ __('admin.name_ar') }}</label>
                    <div class="col-9">
                        <input type="text" name="name_ar" class="form-control m-input" 
                                placeholder="{{ __('admin.name_ar') }}" value="{{ old('name_ar') }}">
                        {!! $errors->first('name_ar', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>

            
            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-danger' : ''}}">
                    <label for="name" class="col-1 col-form-label">{{ __('admin.code') }}</label>
                    <div class="col-9">
                        <input type="text" name="code" class="form-control m-input" 
                                placeholder="{{ __('admin.code') }}" value="{{ old('code') }}">
                        {!! $errors->first('code', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('flag') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.flag') }}</label>
                    <div class="col-9">
                        <input type="file" name="flag" class="form-control m-input" placeholder="{{ __('admin.flag') }}">
                        {!! $errors->first('flag', '<span class="form-control-feedback">:message</span>') !!}
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
                        <a type="reset" href="{{url('admin/country')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->


@endsection