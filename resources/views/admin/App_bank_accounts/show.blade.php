@extends('admin.layouts.index_layout',['title' => __('admin.App_bank_accounts') ])

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
                   {{ $row->name_ar }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{ config('app.admin_url') }}/appbankaccount/{{ $row->id }}" method="post" enctype="multipart/form-data">
       
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
                <label for="name" class="col-1 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ $row->name }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('name_ar') ? 'has-danger' : ''}}">
                <label for="name_ar" class="col-1 col-form-label">{{ __('admin.name_ar') }}</label>
                <div class="col-9">
                    <input type="text" name="name_ar" class="form-control m-input" 
                            placeholder="{{ __('admin.name_ar') }}" value="{{ $row->name_ar }}" disabled="">
                    {!! $errors->first('name_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('IBAN') ? 'has-danger' : ''}}">
                <label for="IBAN" class="col-2 col-form-label">{{ __('admin.IBAN') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.IBAN') }}" name="IBAN" disabled>{{ $row->IBAN }}</textarea>
                    {!! $errors->first('IBAN', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('account_number') ? 'has-danger' : ''}}">
                <label for="account_number" class="col-2 col-form-label">{{ __('admin.account_number') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.account_number') }}" name="account_number" disabled>{{ $row->account_number }}</textarea>
                    {!! $errors->first('account_number', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
           
            <div class="form-group m-form__group row {{ $errors->has('account_name') ? 'has-danger' : ''}}">
                <label for="account_name" class="col-1 col-form-label">{{ __('admin.account_name') }}</label>
                <div class="col-9">
                    <input type="text" name="account_name" class="form-control m-input" 
                            placeholder="{{ __('admin.account_name') }}" value="{{ $row->account_name }}" disabled="">
                    {!! $errors->first('account_name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

           
            <div class="form-group m-form__group row {{ $errors->has('logo') ? 'has-danger' : ''}}">
                    <label for="logo" class="col-2 col-form-label">{{ __('admin.logo') }}</label>
                    <div class="col-9">
                        <img src="{{url('')}}{{ str_replace('public/', '', $row->logo) }}" width="400" height="400" class="form-control">
                    </div>
            </div>

           
          

           


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/appbankaccount')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->


@endsection