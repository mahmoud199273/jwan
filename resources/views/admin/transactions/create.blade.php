@extends('admin.layouts.index_layout',['title' => __('admin.transactions') ])

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
                    {{ __('admin.add') }} | {{ __('admin.transaction') }}
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
        <form class="m-form" action="{{url('admin/transactions')}}" method="post" enctype="multipart/form-data">
       
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
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.name') }}</label>
            <div class="col-9">
                <select name="user_id"  class="form-control">
                                        @if($users)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"> 
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                </select>
                {!! $errors->first('name', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('amount') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.amount') }}</label>
            <div class="col-9">
                <input type="text" name="amount" class="form-control m-input" 
                            placeholder="{{ __('admin.amount') }}" >
                {!! $errors->first('amount', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        
        <div class="form-group m-form__group row {{ $errors->has('transaction_bank_name') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_bank_name') }}</label>
            <div class="col-9">
                <input type="text" name="transaction_bank_name" class="form-control m-input" 
                    placeholder="{{ __('admin.transaction_bank_name') }}" >
                {!! $errors->first('transaction_bank_name', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_account_name') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_name') }}</label>
            <div class="col-9">
                    <input type="text" name="transaction_account_name" class="form-control m-input" 
                    placeholder="{{ __('admin.transaction_account_name') }}" >
                {!! $errors->first('transaction_account_name', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_account_number') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_number') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_account_number') }}" name="privacy_title_ar" ></textarea>
                {!! $errors->first('transaction_account_number', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_account_IBAN') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_account_IBAN') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_account_IBAN') }}" name="transaction_account_IBAN" ></textarea>
                {!! $errors->first('transaction_account_IBAN', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_number') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_number') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_number') }}" name="transaction_number" ></textarea>
                {!! $errors->first('transaction_number', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_date') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_date') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_date') }}" name="influncer_privacy_title" ></textarea>
                {!! $errors->first('transaction_date', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('transaction_amount') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.transaction_amount') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.transaction_amount') }}" name="transaction_amount" ></textarea>
                {!! $errors->first('transaction_amount', '<span class="form-control-feedback">:message</span>') !!}
            </div>
        </div>

        <div class="form-group m-form__group row {{ $errors->has('type') ? 'has-danger' : ''}}">
            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.type') }}</label>
            <div class="col-9">
                <textarea class="form-control m-input" placeholder="{{ __('admin.type') }}" name="type" ></textarea>
                {!! $errors->first('type', '<span class="form-control-feedback">:message</span>') !!}
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
                        <a type="reset" href="{{url('admin/transactions')}}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection