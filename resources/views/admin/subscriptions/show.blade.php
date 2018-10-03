@extends('admin.layouts.index_layout',['title' => __('admin.subscriptions') ])

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
                <h3 class="m-portlet__head-text"> تاريخ التحويل  {{ $subscription->transaction_date }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
    <form class="m-form" action="#" method="post" enctype="multipart/form-data">
       
        <div class="m-portlet__body">

    

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">المستخدم</label>
                <div class="col-9">
                    <span class="form-control"><a href="{{ config('app.admin_url') }}/users/{{ $subscription->user->id }}">{{ $subscription->user->name ?? $subscription->user->phone }}</a></span>
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">نوع المستخدم</label>
                <div class="col-9">
                    <span class="form-control">{{ userType($subscription->user->type) }}</span>
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">الباقة</label>
                <div class="col-9">
                    <span class="form-control">
                        <a href="{{ config('app.admin_url') }}/packages/{{ $subscription->package->id }}" target="_blank">
                            {{ $subscription->package->title }}</a>
                        </span>
                </div>
            </div>


            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">البنك</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->bank_transaction }}</span>
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">المبلغ</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->transaction_amount }} ريال</span>
                </div>
            </div>

             <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">رقم الحوالة</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->transaction_number }}</span>
                </div>
            </div>

             <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">اسم صاحب الحوالة</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->user_name }}</span>
                </div>
            </div>

             <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">تاريخ التحويل</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->transaction_date }}</span>
                </div>
            </div>

             <div class="form-group m-form__group row {{ $errors->has('image') ? 'has-danger' : ''}}">
                <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.image') }}</label>
                <div class="col-7">
                    <img src="{{ config('app.url') }}/{{ $subscription->transaction_image }}" 
                        alt="" width="650" height="450" max-width="650" max-height="450" class="form-control m-input">
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">حالة الموافقة</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->is_approved == '1' ? "تم الموافقة" : "لم يتم الموافقة بعد" }}</span>
                </div>
            </div>


            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">تاريخ البداية</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->started_at }}</span>
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">تاريخ  الانتهاء</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->expired_at }}</span>
                </div>
            </div>
            
            

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">عدد  الإعلاناتت المجانية المتبقية</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->package->number_of_normal_ads - $subscription->free_ads->count() }} / {{ $subscription->package->number_of_normal_ads }}</span>
                </div>
            </div>

            <div class="form-group m-form__group row ">
                <label for="name" class="col-2 col-form-label">عدد  الإعلاناتت المدفوعة المتبقية</label>
                <div class="col-9">
                    <span class="form-control">{{ $subscription->package->number_of_featured_ads - $subscription->paid_ads->count() }} / {{ $subscription->package->number_of_featured_ads }}</span>
                </div>
            </div>


           


        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-9">
                        <a type="reset" href="{{ config('app.admin_url') }}/subscriptions" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection