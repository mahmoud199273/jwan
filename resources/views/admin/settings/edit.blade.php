@extends('admin.layouts.index_layout',['title' => __('admin.settings') ])

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
                   {{ __('admin.edit') }} 
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/settings')}}/{{ $row->id }}" method="post" enctype="multipart/form-data">
       
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

            

            <div class="form-group m-form__group row {{ $errors->has('campaign_period') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.campaign_period') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.campaign_period') }}" name="campaign_period" >{{ $row->campaign_period }}</textarea>
                    {!! $errors->first('campaign_period', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
    
            <div class="form-group m-form__group row {{ $errors->has('commission') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.commission') }}</label>
                <div class="col-9">
                    <input type="text" class="form-control m-input" placeholder="{{ __('admin.commission') }}" name="commission" value="{{ $row->commission }}">
                    {!! $errors->first('commission', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

          

            <!-- <div class="form-group m-form__group row {{ $errors->has('logo') ? 'has-danger' : ''}}">
                    <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.logo') }}</label>
                    <div class="col-9">
                            <input type="hidden" name="logo" id="file" class="form-control m-input" placeholder="{{ __('admin.logo') }}" value="{{ $row->logo }}">
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
                                    <img src="{{url('/assets/uploads')}}/{{ $row->logo }}" id="image_file" width="100" height="100" >
                                </div>
                                {{--   upload image div   --}}
                        {!! $errors->first('logo', '<span class="form-control-feedback">:message</span>') !!}
                    </div>
            </div> -->





            
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <button type="submit" class="btn btn-brand">{{ __('admin.save') }}</button>
                        <a type="reset" href="{{url('admin/settings')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection