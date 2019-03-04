@extends('admin.layouts.index_layout',['title' => __('admin.influencers') ])

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
                  روابط التواصل الاجتماعى  | {{ $row->user->name }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="{{url('admin/influencers')}}/{{ $row->id }}/social/accept" method="post" enctype="multipart/form-data">
       
              {{ csrf_field() }}
              <input type="hidden" name="account_type" value="1" />
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $row->id }}">
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

            <div class="form-group m-form__group row {{ $errors->has('facebook') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Facebook url</label>
                <div class="col-9">
                    <input type="text" name="facebook" class="form-control m-input"
                           value="{{ $row->facebook }}" disabled>
                    {!! $errors->first('facebook', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('facebook_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Facebook Followers</label>
                <div class="col-9">
                    <input type="text" name="facebook_follwers" class="form-control m-input"
                           value="{{ $row->facebook_follwers }}" disabled>
                    {!! $errors->first('facebook_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('twitter') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Twitter url</label>
                <div class="col-9">
                    <input type="text" name="twitter" class="form-control m-input"
                           value="{{ $row->twitter }}" disabled>
                    {!! $errors->first('twitter', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('twitter_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Twitter followers</label>
                <div class="col-9">
                    <input type="text" name="twitter_follwers" class="form-control m-input"
                           value="{{ $row->twitter_follwers }}" disabled>
                    {!! $errors->first('twitter_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('instgrame') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Instgram url</label>
                <div class="col-9">
                    <input type="text" name="instgrame" class="form-control m-input"
                           value="{{ $row->instgrame }}" disabled>
                    {!! $errors->first('instgrame', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('instgrame_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Instgram Followers</label>
                <div class="col-9">
                    <input type="text" name="instgrame_follwers" class="form-control m-input"
                           value="{{ $row->instgrame_follwers }}" disabled>
                    {!! $errors->first('instgrame_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snapchat') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Snapchat url</label>
                <div class="col-9">
                    <input type="text" name="snapchat" class="form-control m-input"
                           value="{{ $row->snapchat }}" disabled>
                    {!! $errors->first('snapchat', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('snapchat_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Snapchat Followers</label>
                <div class="col-9">
                    <input type="text" name="snapchat_follwers" class="form-control m-input"
                           value="{{ $row->snapchat_follwers }}" disabled>
                    {!! $errors->first('snapchat_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            {{-- <div class="form-group m-form__group row {{ $errors->has('linkedin') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">linkedin</label>
                <div class="col-9">
                    <input type="text" name="linkedin" class="form-control m-input"
                           value="{{ $row->linkedin }}" disabled>
                    {!! $errors->first('linkedin', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('linkedin_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">linkedin Followers</label>
                <div class="col-9">
                    <input type="text" name="linkedin_follwers" class="form-control m-input"
                           value="{{ $row->linkedin_follwers }}" disabled>
                    {!! $errors->first('linkedin_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('youtube') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Youtube</label>
                <div class="col-9">
                    <input type="text" name="youtube" class="form-control m-input"
                           value="{{ $row->youtube }}" disabled>
                    {!! $errors->first('youtube', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>

            <div class="form-group m-form__group row {{ $errors->has('youtube_follwers') ? 'has-danger' : ''}}">
                <label for="name" class="col-2 col-form-label">Youtube Followers</label>
                <div class="col-9">
                    <input type="text" name="youtube_follwers" class="form-control m-input"
                           value="{{ $row->youtube_follwers }}" disabled>
                    {!! $errors->first('youtube_follwers', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div> --}}



        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <button type="submit" class="btn btn-brand">تأكيد</button>
                        <a class="btn btn-danger" href="{{url('admin/influencers')}}/{{ $row->id }}/social/reject">رفض </a>
                        <a type="reset" href="{{url('admin/influencers')}}" class="btn btn-secondary">عودة</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection
