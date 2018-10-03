@extends('admin.layouts.index_layout',['title' => __('admin.packages') ])

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
                    {{ $package->title }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" >
       
       
        <div class="m-portlet__body">


            <div class="form-group m-form__group row {{ $errors->has('title') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">{{ __('admin.title') }}</label>
                <div class="col-9">
                    <input type="text" name="title" class="form-control m-input" 
                            placeholder="{{ __('admin.title') }}" value="{{ $package->title }}" disabled>
                    {!! $errors->first('title', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('price') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.price') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.price') }}" name="price" value="{{ $package->price }}" disabled>
                    {!! $errors->first('price', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('period') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.period') }}</label>
                <div class="col-9">
                    <input type="number" class="form-control m-input" 
                            placeholder="{{ __('admin.period') }}" name="period" value="{{ $package->period }}" disabled>
                    {!! $errors->first('period', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('number_of_featured_ads') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">
                {{ __('admin.number_of_featured_ads') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.number_of_featured_ads') }}" name="number_of_featured_ads" value="{{ $package->number_of_featured_ads }}" disabled>
                    {!! $errors->first('number_of_featured_ads', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
            <div class="form-group m-form__group row {{ $errors->has('number_of_normal_ads') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.number_of_normal_ads') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.number_of_normal_ads') }}" name="number_of_normal_ads" value="{{ $package->number_of_normal_ads }}" disabled>
                    {!! $errors->first('number_of_normal_ads', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

           


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{ config('app.admin_url') }}/packages" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection