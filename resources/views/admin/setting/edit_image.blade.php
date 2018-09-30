@extends('admin.layouts.index_layout',['title' => __('admin.setting') ])

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
                    <i class="fa fa-cog"></i>
                </span>
                <h3 class="m-portlet__head-text">
                 {{ __('admin.edit') }} | {{ __('admin.image') }} | {{ $property->name }}
             </h3>
         </div>
     </div>
 </div>

 <!--begin::Form-->
 <form class="m-form" action="{{ config('app.admin_url') }}/property/images/{{ $property->id }}" method="post" 
        enctype="multipart/form-data" name="edit_setting">

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

        
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-form-label">تغير الصورة</label>
            <div class="col-11">
                <input class="form-control m-input" type="file" name="icon">
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
                    <a type="reset" href="{{ config('app.admin_url') }}/dashboard" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!--end::Form-->
</div>

<!--end::Portlet-->

@endsection