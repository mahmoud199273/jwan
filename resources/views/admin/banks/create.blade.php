@extends('admin.layouts.index_layout',['title' => __('admin.banks') ])

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
                   {{ __('admin.add') }} | {{ __('admin.banks') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{ config('app.admin_url') }}/banks" method="post" enctype="multipart/form-data">
       
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
                <label for="name" class="col-2 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ old('name') }}">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('account_name') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.account_name') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.account_name') }}" name="account_name" value="{{ old('account_name') }}">
                    {!! $errors->first('account_name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('account_number') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.account_number') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.account_number') }}" name="account_number" value="{{ old('account_number') }}">
                    {!! $errors->first('account_number', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('iban_account_number') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.iban_account_number') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" 
                            placeholder="{{ __('admin.iban_account_number') }}" name="iban_account_number" value="{{ old('iban_account_number') }}">
                    {!! $errors->first('iban_account_number', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                <div class="col-9">
                    <input type="file" class="form-control m-input" 
                            placeholder="{{ __('admin.image') }}" name="image" accept="images/*">
                    {!! $errors->first('image', '<span class="form-control-feedback">:message</span>') !!}
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
                        <a type="reset" href="{{ config('app.admin_url') }}/banks" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection