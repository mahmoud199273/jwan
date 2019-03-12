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
                   {{ __('admin.add') }} | {{ __('admin.invitationCodes') }}
                </h3>
            </div>
        </div>
    </div>


    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/invitations')}}" method="post" enctype="multipart/form-data">
       
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

            <div class="form-group m-form__group row {{ $errors->has('code') ? 'has-danger' : ''}}">
                <label for="code" class="col-2 col-form-label">{{ __('admin.invitationCode') }}</label>
                <div class="col-9">
                    <input type="text" name="code" class="form-control m-input" 
                            placeholder="{{ __('admin.invitationCode') }}" value="{{ old('code') }}" pattern="[1-9A-Za-z]{4}" >
                    <p class="help-block" style="color:gray">{{__('admin.codeMessage')}}</p>
                    {!! $errors->first('code', '<span class="form-control-feedback">:message</span>') !!}
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