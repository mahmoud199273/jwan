@extends('admin.layouts.index_layout',['title' => __('admin.contact_us') ])

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
                    {{ $complaint->created_at }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="#" method="post" enctype="multipart/form-data">
       
        <div class="m-portlet__body">

   

            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-9">
                    <input type="text" name="name" class="form-control m-input" 
                            placeholder="{{ __('admin.name') }}" value="{{ $complaint->name }}" disabled="">
                    {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>
   

            


            <div class="form-group m-form__group row {{ $errors->has('subject') ? 'has-danger' : ''}}">
                <label for="name" class="col-1 col-form-label">{{ __('admin.subject') }}</label>
                <div class="col-9">
                    <input type="text" name="subject" class="form-control m-input" 
                            placeholder="{{ __('admin.subject') }}" value="{{ $complaint->subject }}" disabled="">
                    {!! $errors->first('subject', '<span class="form-control-feedback">:message</span>') !!}
                </div>
            </div>


            <div class="form-group m-form__group row {{ $errors->has('message') ? 'has-danger' : ''}}">
                <label for="message" class="col-1 col-form-label"> {{ __('admin.message') }}  </label>
                <div class="col-9">
                    <textarea class="form-control m-input" disabled="">{{ $complaint->message }}</textarea>
                </div>
            </div>
           
   


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{url('admin/complaints')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->




@endsection