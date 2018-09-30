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
                 {{ __('admin.edit') }} | {{ __('admin.setting') }}
             </h3>
         </div>
     </div>
 </div>

 <!--begin::Form-->
 <form class="m-form" action="{{ config('app.admin_url') }}/setting/{{ $setting->id }}" method="post" 
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




        <h3>الاعلانات</h3>
        <div class="form-group m-form__group row">
            <div class="col-6">
            <label for="name" class="col-form-label">عدد الاعلانات للمستخدم</label>
                <input type="text" name="number_of_ads_for_user" class="form-control m-input" 
                placeholder="عدد الاعلانات للمستخدم" value="{{ $setting->number_of_ads_for_user }}">
            </div>

            <div class="col-6">
            <label for="name" class="col-form-label">الفترة المتاحة انشر الاعلانات للمستخدم</label>
                <input type="text" name="period_for_user" class="form-control m-input" 
                placeholder="{{ __('admin.first_half') }}" value="{{ $setting->period_for_user }}">
            </div>
            <div class="col-6">
            <label for="name" class="col-form-label">عدد الاعلانات للمكتب</label>
                <input type="text" name="number_of_ads_for_office" class="form-control m-input" 
                placeholder="" value="{{ $setting->number_of_ads_for_office }}">
            </div>
            <div class="col-6">
            <label for="name" class="col-form-label">الفترة المتاحة للمكتب لنشر الاعلانات</label>
                <input type="text" name="period_for_office" class="form-control m-input" 
                placeholder="{{ __('admin.first_half') }}" value="{{ $setting->period_for_office}}">
            </div>
        </div>

       <hr>
        
        <h3>صورة الصفحة الرئيسية</h3>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-form-label">تغير الصور</label>
            <div class="col-11">
                <input class="form-control m-input" type="file" name="home_image">
            </div>
        </div>

        <hr>

         <h3>عنا</h3>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-form-label">عنَا</label>
            <div class="col-11">
                <input class="form-control m-input" type="text" name="about_us" value="{{ $setting->about_us }}">
            </div>
        </div>
        <hr>

         <h3>روابط</h3>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-1 col-form-label">الفيسبوك</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="fb_link" value="{{ $setting->fb_link }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">تويتر</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="twitter_link" value="{{ $setting->twitter_link }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">جوجل</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="google_link" value="{{ $setting->google_link }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">لنكدان</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="linkedin_link" value="{{ $setting->linkedin_link }}">
            </div>
        </div>

         <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">بنترست</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="pintrist_link" value="{{ $setting->pintrist_link }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">جوجل بلاي</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="google_play_link" value="{{ $setting->google_play_link }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">ابل</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="apple_link" value="{{ $setting->apple_link }}">
            </div>
        </div>

        <hr>


         <h3>بيانات التواصل</h3>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-1 col-form-label">العوان</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="address" value="{{ $setting->address }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">الجوال</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="phone" value="{{ $setting->phone }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">البريد الالكتروني</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="email" value="{{ $setting->email }}">
            </div>
        </div>

        <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-1 col-form-label">رقم الفاكس</label>
            <div class="col-8">
                <input class="form-control m-input" type="text" name="fax" value="{{ $setting->fax }}">
            </div>
        </div>



        <hr>




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