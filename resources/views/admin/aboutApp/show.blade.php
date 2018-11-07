@extends('admin.layouts.index_layout',['title' => __('admin.bank_accounts') ])

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
    <form class="m-form" action="{{ config('app.admin_url') }}/aboutApp/{{ $row->id }}" method="post" enctype="multipart/form-data">
       
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

            <div class="form-group m-form__group row {{ $errors->has('body') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.body') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.body') }}" name="body" disabled>{{ $row->body }}</textarea>
                    {!! $errors->first('body', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('body_ar') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.body_ar') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.body_ar') }}" name="body_ar" disabled>{{ $row->body_ar }}</textarea>
                    {!! $errors->first('body_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            

            <div class="form-group m-form__group row {{ $errors->has('fb_link') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.fb_link') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.fb_link') }}" name="fb_link" disabled>{{ $row->fb_link }}</textarea>
                    {!! $errors->first('fb_link', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('twitter_link') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.twitter_link') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.twitter_link') }}" name="twitter_link" disabled>{{ $row->twitter_link }}</textarea>
                    {!! $errors->first('twitter_link', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('google_link') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.google_link') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.google_link') }}" name="google_link" disabled>{{ $row->google_link }}</textarea>
                    {!! $errors->first('google_link', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('insta_link') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.insta_link') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.insta_link') }}" name="insta_link" disabled>{{ $row->insta_link }}</textarea>
                    {!! $errors->first('insta_link', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snap_link') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.snap_link') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.snap_link') }}" name="snap_link" disabled>{{ $row->snap_link }}</textarea>
                    {!! $errors->first('snap_link', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('privacy_title') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.privacy_title') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.privacy_title') }}" name="privacy_title" disabled>{{ $row->privacy_title }}</textarea>
                    {!! $errors->first('privacy_title', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('privacy_title_ar') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.privacy_title_ar') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.privacy_title_ar') }}" name="privacy_title_ar" disabled>{{ $row->privacy_title_ar }}</textarea>
                    {!! $errors->first('privacy_title_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('privacy_policy') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.privacy_policy') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.privacy_policy') }}" name="privacy_policy" disabled>{{ $row->privacy_policy }}</textarea>
                    {!! $errors->first('privacy_policy', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('privacy_policy_ar') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.privacy_policy_ar') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.privacy_policy_ar') }}" name="privacy_policy_ar" disabled>{{ $row->privacy_policy_ar }}</textarea>
                    {!! $errors->first('privacy_policy_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('influncer_privacy_title') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.influncer_privacy_title') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.influncer_privacy_title') }}" name="influncer_privacy_title" disabled>{{ $row->influncer_privacy_title }}</textarea>
                    {!! $errors->first('influncer_privacy_title', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('influncer_privacy_policy') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.influncer_privacy_policy') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.influncer_privacy_policy') }}" name="influncer_privacy_policy" disabled>{{ $row->influncer_privacy_policy }}</textarea>
                    {!! $errors->first('influncer_privacy_policy', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('influncer_privacy_title_ar') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.influncer_privacy_title_ar') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.influncer_privacy_title_ar') }}" name="influncer_privacy_title_ar" disabled>{{ $row->influncer_privacy_title_ar }}</textarea>
                    {!! $errors->first('influncer_privacy_title_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('influncer_privacy_policy_ar') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.influncer_privacy_policy_ar') }}</label>
                <div class="col-9">
                    <textarea class="form-control m-input" placeholder="{{ __('admin.influncer_privacy_policy_ar') }}" name="influncer_privacy_policy_ar" disabled>{{ $row->influncer_privacy_policy_ar }}</textarea>
                    {!! $errors->first('influncer_privacy_policy_ar', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
  


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/aboutApp')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->


@endsection